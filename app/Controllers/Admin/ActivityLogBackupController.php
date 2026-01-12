<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ActivityLogArchiveModel;
use App\Models\ActivityLogModel;

class ActivityLogBackupController extends BaseController
{
    protected $archiveModel;

    public function __construct()
    {
        $this->archiveModel = new ActivityLogArchiveModel();
    }

    public function index()
{
    if (session()->get('role') !== 'admin') {
        return redirect()->back();
    }

    $dir = WRITEPATH . 'backups/activity_logs/';
    $backups = [];

    if (is_dir($dir)) {
        foreach (glob($dir . '*.json') as $jsonFile) {

            $content = json_decode(file_get_contents($jsonFile), true);
            if (!isset($content['meta'], $content['data'])) continue;

            $meta = $content['meta'];
            $base = basename($jsonFile, '.json');

            $backups[] = [
                'period'     => $meta['period']['from'] . ' s/d ' . $meta['period']['to'],
                'total'      => $meta['total_records'],
                'created_at' => $meta['created_at'],
                'json_file'  => basename($jsonFile),
                'csv_file'   => $base . '.csv',
            ];
        }
    }

    return view('admin/activity_logs/backup', [
        'title'   => 'Backup & Restore Log Aktivitas',
        'backups' => $backups,
    ]);
}

 public function backup()
{
    if (session()->get('role') !== 'admin') {
        return redirect()->back();
    }

    $logs = $this->archiveModel->findAll();
    if (empty($logs)) {
        return redirect()->back()->with('error', 'Tidak ada log arsip untuk dibackup.');
    }

    $dir = WRITEPATH . 'backups/activity_logs/';
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $timestamp = date('Ymd_His');
    $baseName  = 'activity_logs_archive_' . $timestamp;

    /* ======================
     * 1️⃣ JSON + METADATA
     * ====================== */
    $jsonPath = $dir . $baseName . '.json';

    $createdAt = date('Y-m-d H:i:s');

    $meta = [
        'type'           => 'activity_logs_archive',
        'total_records'  => count($logs),
        'period' => [
            'from' => min(array_column($logs, 'created_at')),
            'to'   => max(array_column($logs, 'created_at')),
        ],
        'created_at' => $createdAt,
        'created_by' => session()->get('username') ?? 'admin',
    ];

    file_put_contents($jsonPath, json_encode([
        'meta' => $meta,
        'data' => $logs
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    /* ======================
     * 2️⃣ CSV (AUDIT)
     * ====================== */
    $csvPath = $dir . $baseName . '.csv';

    $fp = fopen($csvPath, 'w');

// BOM UTF-8 (WAJIB BIAR EXCEL GA RUSAK)
fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

// HEADER
fputcsv($fp, [
    'Tanggal',
    'Nama User',
    'Role',
    'Aksi',
    'Deskripsi',
    'Subjek',
    'IP Address',
    'User Agent'
], ';', '"');

foreach ($logs as $log) {

    // 🔥 BERSIHKAN TEXT BIAR GA PECAH
    $description = preg_replace("/\r|\n/", ' ', $log['description']);
    $userAgent   = preg_replace("/\r|\n/", ' ', $log['user_agent']);

    fputcsv($fp, [
        date('d-m-Y H:i', strtotime($log['created_at'])),
        $log['username'] ?? $log['nama'] ?? 'System',
        strtoupper($log['role']),
        strtoupper($log['action']),
        $description,
        ($log['subject_type'] ?? '-') . ' #' . ($log['subject_id'] ?? '-'),
        $log['ip_address'],
        $userAgent,
    ], ';', '"');
}

fclose($fp);
// ======================

$periodStart = $meta['period']['from'];
$periodEnd   = $meta['period']['to'];

    // ======================
    // 🔥 LOG BACKUP ARSIP
log_activity(
    'LOG_ARCHIVE_BACKUP',
    'Backup log arsip berhasil dibuat untuk periode ' .
    $periodStart . ' sampai ' . $periodEnd .
    ' dengan total ' . count($logs) . ' data.',
    'activity_logs_archive'
);

    return redirect()->back()->with('success', 'Backup JSON + CSV berhasil dibuat.');
}

public function restore()
{
    if (session()->get('role') !== 'admin') {
        return redirect()->back();
    }

    $file = $this->request->getPost('file') 
         ?? $this->request->getPost('backup_file');

    if (!$file) {
        return redirect()->back()->with('error', 'File backup tidak ditemukan.');
    }

    $path = WRITEPATH . 'backups/activity_logs/' . $file;

    if (!file_exists($path)) {
        return redirect()->back()->with('error', 'File backup tidak valid.');
    }

    $json = json_decode(file_get_contents($path), true);

    if (!isset($json['data'])) {
        return redirect()->back()->with('error', 'Format backup tidak valid.');
    }

    $logs = $json['data'];
    $logModel = new ActivityLogModel();

    foreach ($logs as $log) {

        // Hindari bentrok PK
        unset($log['id']);

        /**
         * 🔥 FIX FK USER
         * kalau user_id tidak ada → fallback ke SYSTEM (id=1)
         */
        if (!isset($log['user_id']) || !$this->userExists($log['user_id'])) {
            $log['user_id'] = 1; // SYSTEM
        }

        /**
         * =========================
         * 🔥 TANDAI HASIL RESTORE
         * =========================
         */
        $log['is_restored']          = 1;
        $log['restored_at']          = date('Y-m-d H:i:s');
        $log['restored_from_backup'] = $file;

        /**
         * (Logika lama tetap)
         */
        $log['action'] = 'RESTORED_' . strtoupper($log['action']);

        $logModel->insert($log);
    }
// ======================
    // ======================
    // 🔥 LOG RESTORE ARSIP
    log_activity(
    'LOG_ARCHIVE_RESTORE',
    'Data log aktivitas berhasil direstore dari file backup ' . $file . '.',
    'activity_logs'
);

    return redirect()->back()->with(
        'success',
        'Restore berhasil. Data ditandai sebagai RESTORED.'
    );
}

/**
 * 🔍 CEK USER EXIST
 */
private function userExists($userId)
{
    return db_connect()
        ->table('users')
        ->where('id', $userId)
        ->countAllResults() > 0;
}

    public function download($filename)
{
    if (session()->get('role') !== 'admin') {
        return redirect()->back();
    }

    $path = WRITEPATH . 'backups/activity_logs/' . $filename;

    if (!file_exists($path)) {
        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }
    /**
     * 🔥 LOG AKTIVITAS AUDIT CSV
     */
    log_activity(
        'LOG_ARCHIVE_AUDIT_DOWNLOAD',
        'Admin mengunduh file audit log arsip: ' . $filename,
        'activity_logs_archive'
    );

    

    return $this->response
        ->download($path, null)
        ->setFileName($filename);
}

}
