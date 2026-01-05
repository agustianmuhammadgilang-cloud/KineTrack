<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\ActivityLogModel;
use App\Models\ActivityLogArchiveModel;
use App\Models\ActivityLogScheduleModel;

class LogsScheduleCommand extends BaseCommand
{
    protected $group       = 'Logs';
    protected $name        = 'logs:schedule';
    protected $description = 'Menjalankan penjadwalan log aktivitas (archive & cleanup otomatis)';

    protected function initSystemSession()
{
    $session = session();

    // Jangan override kalau ternyata ada (future-proof)
    if (!$session->has('user_id')) {
        $session->set([
            'user_id'  => 1,          // ID SYSTEM (wajib ada di tabel users)
            'role'     => 'system',
            'username' => 'SYSTEM',
        ]);
    }
}

    public function run(array $params)
    {
        CLI::write('Menjalankan penjadwalan log aktivitas...', 'yellow');

        $scheduleModel = new ActivityLogScheduleModel();
        $config = $scheduleModel->first();

        if (!$config) {
            CLI::error('Konfigurasi penjadwalan log belum tersedia.');
            return;
        }

        $archiveMonths = (int) $config['archive_after_months'];
        $deleteMonths  = (int) $config['delete_after_months'];

        $logModel     = new ActivityLogModel();
        $archiveModel = new ActivityLogArchiveModel();

        /**
         * ======================================================
         * 1. ARCHIVE LOG AKTIF (> X BULAN)
         * ======================================================
         */
        $archiveLimitDate = date('Y-m-d H:i:s', strtotime("-{$archiveMonths} months"));

        $logsToArchive = $logModel
            ->where('created_at <', $archiveLimitDate)
            ->findAll();

        foreach ($logsToArchive as $log) {
            $archiveModel->insert([
                'user_id'      => $log['user_id'],
                'role'         => $log['role'],
                'action'       => $log['action'],
                'description'  => $log['description'],
                'subject_type' => $log['subject_type'],
                'subject_id'   => $log['subject_id'],
                'ip_address'   => $log['ip_address'],
                'user_agent'   => $log['user_agent'],
                'created_at'   => $log['created_at'],
                'archived_at'  => date('Y-m-d H:i:s'),
            ]);

            $logModel->delete($log['id']);
        }
// ======================
            // 🔥 LOG PENJADWALAN ARCHIVE
        if (count($logsToArchive) > 0) {
    log_activity(
        'LOG_SCHEDULE_ARCHIVE',
        'Penjadwalan otomatis berhasil mengarsipkan ' .
        count($logsToArchive) .
        ' log aktivitas yang lebih lama dari ' .
        $archiveMonths . ' bulan.',
        'activity_logs'
    );
}
        // FIX: ganti CLI::success()
        CLI::write(count($logsToArchive) . ' log berhasil diarsipkan.', 'green');

        /**
         * ======================================================
         * 2. CLEANUP LOG ARSIP (> Y BULAN)
         * ======================================================
         */
        $deleteLimitDate = date('Y-m-d H:i:s', strtotime("-{$deleteMonths} months"));

        $archiveModel
            ->where('archived_at <', $deleteLimitDate)
            ->delete();
            // ======================
            // 🔥 LOG PENJADWALAN CLEANUP
        log_activity(
    'LOG_SCHEDULE_CLEANUP',
    'Penjadwalan otomatis membersihkan log arsip yang disimpan lebih dari ' .
    $deleteMonths . ' bulan.',
    'activity_logs_archive'
);
        // FIX: ganti CLI::success()
        CLI::write('Proses cleanup log arsip selesai.', 'green');
        // ======================
            // 3. LOG PENJADWALAN SELESAI
            // ======================
        log_activity(
    'LOG_SCHEDULE_RUN',
    'Siklus penjadwalan log aktivitas berhasil dijalankan tanpa error.',
    'system'
);
        CLI::write('Penjadwalan log selesai dijalankan.', 'green');
    }
}