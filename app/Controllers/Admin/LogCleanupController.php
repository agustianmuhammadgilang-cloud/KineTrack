<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ActivityLogArchiveModel;
use CodeIgniter\Database\BaseConnection;

class LogCleanupController extends BaseController
{
    protected $archiveModel;
    protected $db;
    protected $backupPath;

    public function __construct()
    {
        $this->archiveModel = new ActivityLogArchiveModel();
        $this->db = \Config\Database::connect();
        $this->backupPath = WRITEPATH . 'backups/activity_logs/';
    }

    /**
     * =========================================
     * 🔐 CEK BACKUP VALID (DATABASE + FILE)
     * =========================================
     */
/**
 * =========================================
 * 🔐 CEK BACKUP VALID & RELEVAN (AUTO LOCK)
 * =========================================
 */
/**
 * =========================================
 * 🔐 CEK BACKUP VALID & RELEVAN (AUTO LOCK)
 * =========================================
 */
private function hasValidBackup(): bool
{
    // 1️⃣ Ambil backup terakhir
    $backup = $this->db->table('activity_log_backups')
        ->orderBy('created_at', 'DESC')
        ->get()
        ->getFirstRow('array');

    if (!$backup) {
        return false; // belum pernah backup
    }

    // 2️⃣ Pastikan file backup masih ada
    $backupFile = WRITEPATH . 'backups/activity_logs/' . $backup['file_path'];
    if (!file_exists($backupFile)) {
        return false;
    }

    // 3️⃣ Ambil WAKTU ARSIP TERAKHIR (PAKAI archived_at!)
    $lastArchive = $this->archiveModel
        ->selectMax('archived_at')
        ->get()
        ->getRowArray();

    // Jika tabel arsip kosong → aman
    if (!$lastArchive || !$lastArchive['archived_at']) {
        return true;
    }

    /**
     * 🔥 LOGIKA FINAL (BENAR)
     * Backup harus lebih BARU dari arsip terakhir
     */
    return strtotime($backup['created_at']) >= strtotime($lastArchive['archived_at']);
}

    /**
     * =========================================
     * HALAMAN CLEANUP
     * =========================================
     */
    public function index()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back();
        }

        $totalArchive = $this->archiveModel->countAllResults();
        $hasBackup    = $this->hasValidBackup();

        return view('admin/activity_logs/cleanup', [
            'title'         => 'Pemberesan Log Arsip',
            'total_archive' => $totalArchive,
            'has_backup'    => $hasBackup
        ]);
    }

    /**
     * =========================================
     * EKSEKUSI CLEANUP (LOCK KETAT)
     * =========================================
     */
    public function run()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back();
        }

        /**
         * 🔒 HARD LOCK
         */
        if (!$this->hasValidBackup()) {
            return redirect()->back()->with(
                'error',
                'Pembersihan DIBLOKIR. Backup arsip belum dibuat atau file backup tidak ditemukan.'
            );
        }

        $scope = $this->request->getPost('scope');

        if (!$scope) {
            return redirect()->back()->with(
                'error',
                'Scope pembersihan tidak valid.'
            );
        }

        /**
         * =========================================
         * EKSEKUSI
         * =========================================
         */
        if ($scope === 'all') {

            $this->archiveModel->truncate();

        } else {

            $months = (int) $scope;
            if ($months <= 0) {
                return redirect()->back()->with(
                    'error',
                    'Parameter bulan tidak valid.'
                );
            }

            $limitDate = date('Y-m-d H:i:s', strtotime("-{$months} months"));

            $this->archiveModel
                ->where('created_at <', $limitDate)
                ->delete();
        }
// ======================
            // 🔥 LOG CLEANUP ARSIP
            
        log_activity(
    action: 'CLEANUP_ARCHIVE',
    description: 'Menghapus seluruh data log arsip setelah backup tervalidasi.',
    subjectType: 'activity_logs_archive'
);

        return redirect()->to(
            base_url('admin/activity-logs/archive')
        )->with(
            'success',
            'Pembersihan arsip berhasil. Backup terverifikasi.'
        );
    }
}