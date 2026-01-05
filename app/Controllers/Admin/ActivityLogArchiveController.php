<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ActivityLogArchiveModel;
use App\Models\ActivityLogModel;


class ActivityLogArchiveController extends BaseController
{
    protected $archiveModel;

    public function __construct()
    {
        $this->archiveModel = new ActivityLogArchiveModel();
    }

    /**
     * Halaman Log Arsip (Admin Only)
     */
    public function index()
    {
        // Proteksi role
        if (session()->get('role') !== 'admin') {
            return redirect()->back();
        }

        // Filter periode (opsional)
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $builder = $this->archiveModel
            ->select('activity_logs_archive.*, users.nama')
            ->join('users', 'users.id = activity_logs_archive.user_id', 'left')
            ->orderBy('activity_logs_archive.created_at', 'DESC');

        if ($bulan && $tahun) {
            $builder->where('MONTH(activity_logs_archive.created_at)', $bulan)
                    ->where('YEAR(activity_logs_archive.created_at)', $tahun);
        }

        $data = [
            'title' => 'Log Aktivitas Arsip',
            'logs'  => $builder->findAll(),
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];

        return view('admin/activity_logs/archive', $data);
    }
    
public function backup()
{
    if (session()->get('role') !== 'admin') {
        return redirect()->back();
    }

    $logs = $this->archiveModel
        ->select('activity_logs_archive.*, users.nama')
        ->join('users', 'users.id = activity_logs_archive.user_id', 'left')
        ->orderBy('activity_logs_archive.created_at', 'ASC')
        ->findAll();

    if (empty($logs)) {
        return redirect()->back()->with('error', 'Tidak ada log arsip untuk dibackup.');
    }

    $dir = WRITEPATH . 'backups/activity_logs/';
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $timestamp = date('Ymd_His');
    $baseName  = 'activity_logs_archive_' . $timestamp;

    // ======================
    // META DATA
    // ======================
    $periodStart = date('Y-m-d', strtotime($logs[0]['created_at']));
    $periodEnd   = date('Y-m-d', strtotime(end($logs)['created_at']));

    $meta = [
        'type'           => 'ARCHIVE_BACKUP',
        'total_records'  => count($logs),
        'period' => [
            'from' => $periodStart,
            'to'   => $periodEnd,
        ],
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => session()->get('nama') ?? 'admin',
    ];

    // ======================
    // JSON BACKUP
    // ======================
    $jsonPath = $dir . $baseName . '.json';
    file_put_contents($jsonPath, json_encode([
        'meta' => $meta,
        'data' => $logs
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    // ======================
    // CSV BACKUP
    // ======================
    $csvPath = $dir . $baseName . '.csv';
    $fp = fopen($csvPath, 'w');

    // BOM UTF-8 (Excel Safe)
    fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

    fputcsv($fp, [
        'Tanggal',
        'Nama User',
        'Role',
        'Aksi',
        'Deskripsi',
        'Subjek',
        'IP Address',
        'User Agent'
    ], ';');

    foreach ($logs as $log) {
        $description = trim(preg_replace('/\s+/', ' ', $log['description']));
        $userAgent   = trim(preg_replace('/\s+/', ' ', $log['user_agent']));

        fputcsv($fp, [
            date('d-m-Y H:i', strtotime($log['created_at'])),
            $log['nama'] ?? 'System',
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
    // 🔥 SIMPAN KE DATABASE BACKUP (INI KUNCI)
    // ======================
    db_connect()->table('activity_log_backups')->insert([
        'backup_name'   => $baseName,
        'file_path' => $baseName . '.json',
        'period_start'  => $periodStart,
        'period_end'    => $periodEnd,
        'created_by'    => session()->get('user_id'),
        'created_at'    => date('Y-m-d H:i:s'),
    ]);
// ======================
            // 🔥 LOG BACKUP ARSIP
    log_activity(
    'LOG_ARCHIVE_BACKUP',
    'Backup log arsip berhasil dibuat untuk periode ' .
    $periodStart . ' sampai ' . $periodEnd .
    ' dengan total ' . count($logs) . ' data.',
    'activity_logs_archive'
);

    return redirect()->to('admin/activity-logs/backup')
        ->with('success', 'Backup arsip berhasil & tercatat secara aman.');
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

        unset($log['id']); // hindari PK bentrok

        /**
         * 🔥 FIX FK USER
         * kalau user_id tidak ada → fallback ke SYSTEM (id=1)
         */
        if (!isset($log['user_id']) || !$this->userExists($log['user_id'])) {
            $log['user_id'] = 1; // SYSTEM
        }

        /**
         * 🔥 TANDAI DATA RESTORE
         */
        $log['action'] = 'RESTORED_' . strtoupper($log['action']);

        $logModel->insert($log);
    }

    // ======================
    // 🔥 LOG RESTORE ARSIP
    log_activity(
    'LOG_ARCHIVE_RESTORE',
    'Data log aktivitas berhasil direstore dari file backup ' . $file . '.',
    'activity_logs'
);

    return redirect()->back()->with(
        'success',
        'Restore berhasil. Data aman & FK terjaga.'
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


}
