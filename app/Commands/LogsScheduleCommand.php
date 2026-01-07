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
    protected $description = 'Menjalankan penjadwalan log aktivitas (archive, auto backup & cleanup)';

    protected function initSystemSession()
    {
        $session = session();

        if (!$session->has('user_id')) {
            $session->set([
                'user_id'  => 1,
                'role'     => 'system',
                'username' => 'SYSTEM',
            ]);
        }
    }

    /**
     * ===============================
     * SYSTEM REMINDER (POST-ACTION)
     * ===============================
     */
    protected function systemReminder(
        string $actionType,
        string $message,
        string $relatedTable,
        int $totalData,
        string $status = 'success'
    ) {
        db_connect()->table('system_reminders')->insert([
            'action_type'   => $actionType,
            'message'       => $message,
            'related_table' => $relatedTable,
            'total_data'    => $totalData,
            'status'        => $status,
            'executed_at'   => date('Y-m-d H:i:s'),
            'created_at'    => date('Y-m-d H:i:s'),
        ]);
    }

    public function run(array $params)
    {
        $this->initSystemSession();

        CLI::write('Menjalankan penjadwalan log aktivitas...', 'yellow');

        $scheduleModel = new ActivityLogScheduleModel();
        $config = $scheduleModel->first();

        if (!$config) {
            CLI::error('Konfigurasi penjadwalan log belum tersedia.');
            return;
        }

        $archiveMonths = (int) $config['archive_after_months'];
        $deleteMonths  = (int) $config['delete_after_months'];
        $autoBackup    = (int) $config['auto_backup'];

        $logModel     = new ActivityLogModel();
        $archiveModel = new ActivityLogArchiveModel();
        $db           = db_connect();

        // 🔐 FLAG: backup hanya boleh jalan jika ada proses archive
        $hasArchiveProcess = false;

        /**
         * ======================================================
         * 1️⃣ ARCHIVE LOG AKTIF
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

        if (count($logsToArchive) > 0) {

            $hasArchiveProcess = true;

            log_activity(
                'LOG_SCHEDULE_ARCHIVE',
                'Penjadwalan otomatis mengarsipkan ' . count($logsToArchive) .
                ' log aktivitas lebih lama dari ' . $archiveMonths . ' bulan.',
                'activity_logs'
            );

            $this->systemReminder(
                'ARCHIVE',
                'Proses arsip log otomatis selesai dijalankan.',
                'activity_logs',
                count($logsToArchive)
            );
        }

        CLI::write(count($logsToArchive) . ' log berhasil diarsipkan.', 'green');

        /**
         * ======================================================
         * 2️⃣ AUTO BACKUP LOG ARSIP
         * (HANYA JIKA ADA ARCHIVE)
         * ======================================================
         */
        if ($autoBackup === 1 && $hasArchiveProcess === true) {

            $archiveLogs = $archiveModel
                ->orderBy('created_at', 'ASC')
                ->findAll();

            if (!empty($archiveLogs)) {

                $backupDir = WRITEPATH . 'backups/activity_logs/';
                if (!is_dir($backupDir)) {
                    mkdir($backupDir, 0777, true);
                }

                $timestamp = date('Ymd_His');
                $baseName  = 'activity_logs_archive_' . $timestamp;

                $periodStart = date('Y-m-d', strtotime($archiveLogs[0]['created_at']));
                $periodEnd   = date('Y-m-d', strtotime(end($archiveLogs)['created_at']));

                file_put_contents(
                    $backupDir . $baseName . '.json',
                    json_encode([
                        'meta' => [
                            'type'          => 'AUTO_ARCHIVE_BACKUP',
                            'total_records' => count($archiveLogs),
                            'period' => [
                                'from' => $periodStart,
                                'to'   => $periodEnd,
                            ],
                            'created_at' => date('Y-m-d H:i:s'),
                            'created_by' => 'SYSTEM',
                        ],
                        'data' => $archiveLogs
                    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
                );

                $db->table('activity_log_backups')->insert([
                    'backup_name'  => $baseName,
                    'file_path'    => $baseName . '.json',
                    'period_start' => $periodStart,
                    'period_end'   => $periodEnd,
                    'created_by'   => 1,
                    'created_at'   => date('Y-m-d H:i:s'),
                ]);

                log_activity(
                    'LOG_SCHEDULE_AUTO_BACKUP',
                    'Backup otomatis log arsip dibuat (' . count($archiveLogs) . ' data).',
                    'activity_logs_archive'
                );

                $this->systemReminder(
                    'BACKUP',
                    'Backup otomatis log arsip berhasil dibuat.',
                    'activity_logs_archive',
                    count($archiveLogs)
                );

                CLI::write('Auto backup log arsip berhasil.', 'green');
            }
        }

        /**
         * ======================================================
         * 3️⃣ CLEANUP LOG ARSIP
         * ======================================================
         */
        $deleteLimitDate = date('Y-m-d H:i:s', strtotime("-{$deleteMonths} months"));

        $deleted = $archiveModel
            ->where('archived_at <', $deleteLimitDate)
            ->countAllResults();

        if ($deleted > 0) {

            $archiveModel
                ->where('archived_at <', $deleteLimitDate)
                ->delete();

            log_activity(
                'LOG_SCHEDULE_CLEANUP',
                'Penjadwalan otomatis membersihkan log arsip lebih lama dari ' .
                $deleteMonths . ' bulan.',
                'activity_logs_archive'
            );

            $this->systemReminder(
                'CLEANUP',
                'Pembersihan log arsip otomatis selesai.',
                'activity_logs_archive',
                $deleted
            );
        }

        CLI::write('Proses cleanup log arsip selesai.', 'green');

        log_activity(
            'LOG_SCHEDULE_RUN',
            'Siklus penjadwalan log aktivitas dijalankan oleh sistem.',
            'system'
        );

        CLI::write('Penjadwalan log selesai dijalankan.', 'green');
    }
}