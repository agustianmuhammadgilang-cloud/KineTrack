<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\ActivityLogModel;
use CodeIgniter\Database\BaseConnection;

class ArchiveActivityLogs extends BaseCommand
{
    protected $group       = 'Logs';
    protected $name        = 'logs:archive';
    protected $description = 'Arsipkan activity log yang lebih dari 3 bulan';

    protected $activityLogModel;
    protected $db;
    
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

    public function __construct()
    {
        $this->activityLogModel = new ActivityLogModel();
        $this->db = \Config\Database::connect();
    }

    public function run(array $params)
    {
        CLI::write('Mulai proses archive activity log...', 'yellow');

        // Batas waktu arsip: 3 bulan
        $archiveDate = date('Y-m-d H:i:s', strtotime('-3 months'));

        // Ambil log lama
        $logs = $this->activityLogModel
            ->where('created_at <', $archiveDate)
            ->findAll();

        if (empty($logs)) {
            CLI::write('Tidak ada log yang perlu diarsipkan.', 'green');
            return;
        }

        $this->db->transStart();

        foreach ($logs as $log) {
            // Tambahkan archived_at
            $log['archived_at'] = date('Y-m-d H:i:s');

            // Insert ke tabel arsip
            $this->db->table('activity_logs_archive')->insert($log);

            // Hapus dari tabel aktif
            $this->db->table('activity_logs')
                     ->where('id', $log['id'])
                     ->delete();
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            CLI::error('Gagal melakukan archive log.');
            return;
        }

        log_activity(
    'LOG_ARCHIVE',
    'Sistem mengarsipkan ' . count($logs) .
    ' log aktivitas yang dibuat sebelum ' .
    date('d M Y', strtotime($archiveDate)) .
    ' ke penyimpanan arsip.',
    'activity_logs'
);

        CLI::write(
            count($logs) . ' log berhasil dipindahkan ke arsip.',
            'green'
        );
    }
}
