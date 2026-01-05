<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ActivityLogScheduleModel;

class ActivityLogScheduleController extends BaseController
{
    protected $scheduleModel;

    public function __construct()
    {
        $this->scheduleModel = new ActivityLogScheduleModel();
    }

    /**
     * Tampilkan halaman Penjadwalan Log
     */
    public function index()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back();
        }

        // Ambil konfigurasi pertama (boleh kosong)
        $config = $this->scheduleModel->first();

        $data = [
            'title'  => 'Penjadwalan Log Aktivitas',
            'config' => $config, // bisa null, UI aman
        ];

        return view('admin/activity_logs/schedule', $data);
    }

    /**
     * Simpan perubahan jadwal
     */
    public function update()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back();
        }

        $archiveAfter = (int) $this->request->getPost('archive_after_months');
        $deleteAfter  = (int) $this->request->getPost('delete_after_months');
        $autoBackup   = $this->request->getPost('auto_backup') ? 1 : 0;

        // Validasi sederhana (UX aman)
        if ($archiveAfter < 1 || $deleteAfter <= $archiveAfter) {
            return redirect()->back()
                ->with('error', 'Nilai bulan tidak valid. Pastikan hapus > arsip.');
        }

        $existing = $this->scheduleModel->first();

        $payload = [
            'archive_after_months' => $archiveAfter,
            'delete_after_months'  => $deleteAfter,
            'auto_backup'          => $autoBackup,
        ];

        if ($existing) {
            $this->scheduleModel->update($existing['id'], $payload);
        } else {
            $this->scheduleModel->insert($payload);
        }

        // Tentukan status backup
$backupText = $autoBackup ? 'backup otomatis aktif' : 'backup otomatis nonaktif';

// Tentukan konteks (baru / update)
$actionText = $existing
    ? 'memperbarui'
    : 'menetapkan jadwal log pertama kali';

// Catat activity log
log_activity(
    'update_log_schedule',
    "Admin {$actionText} jadwal log: arsip setelah {$archiveAfter} bulan, hapus setelah {$deleteAfter} bulan, {$backupText}",
    'activity_log_schedule',
    $existing['id'] ?? null
);

        return redirect()->back()->with('success', 'Pengaturan penjadwalan log berhasil disimpan.');
    }
}
