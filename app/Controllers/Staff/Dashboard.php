<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\TahunAnggaranModel;
use App\Models\TwModel;
use App\Models\PicModel;
use App\Models\PengukuranModel;
use App\Models\DokumenModel;
use App\Models\NotificationModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userId = session('user_id');

        // 1. Tahun Anggaran Aktif
        $tahunModel = new TahunAnggaranModel();
        $tahunAktif = $tahunModel
            ->where('status', 'active')
            ->first();

        // 2. Triwulan Aktif
        $twModel = new TwModel();
        $twAktif = $twModel
            ->where('is_open', 1)
            ->first();

        // 3. Total PIC Aktif
        $picModel = new PicModel();
        $totalPicAktif = $picModel
            ->where('user_id', $userId)
            ->countAllResults();

        // 4. Indikator Belum 100%
        // $pengukuranModel = new PengukuranModel();
        // $indikatorBelumSelesai = $pengukuranModel
        //     ->where('user_id', $userId)
        //     ->where('progress <', 100)
        //     ->countAllResults();

        // 5. Dokumen Perlu Revisi
        $dokumenModel = new DokumenModel();
        $dokumenRevisi = $dokumenModel
            ->where('created_by', $userId)
            ->whereIn('status', ['rejected_kaprodi', 'rejected_kajur'])
            ->countAllResults();

        // 6. Notifikasi Unread
        $notifModel = new NotificationModel();
        $notifikasi = $notifModel
            ->where('user_id', $userId)
            ->where('status', 'unread')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('staff/dashboard', [
            'tahunAktif'            => $tahunAktif,
            'twAktif'               => $twAktif,
            'totalPicAktif'         => $totalPicAktif,
            // 'indikatorBelumSelesai' => $indikatorBelumSelesai,
            'dokumenRevisi'         => $dokumenRevisi,
            'notifikasi'            => $notifikasi,
        ]);
    }
}
