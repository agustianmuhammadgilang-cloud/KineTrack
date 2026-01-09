<?php

namespace App\Controllers\Atasan;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\TahunAnggaranModel;
use App\Models\TwModel;
use App\Models\PicModel;
use App\Models\DokumenModel;
use App\Models\NotificationModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userId = session('user_id');

        // 1. Ambil data user atasan
        $userModel = new UserModel();
        $atasan = $userModel
            ->select('users.*, jabatan.nama_jabatan, bidang.nama_bidang')
            ->join('jabatan', 'jabatan.id = users.jabatan_id', 'left')
            ->join('bidang', 'bidang.id = users.bidang_id', 'left')
            ->find($userId);

        // 2. Tahun Anggaran aktif
        $tahunModel = new TahunAnggaranModel();
        $tahunAktif = $tahunModel->where('status', 'active')->first();

        // 3. Triwulan aktif
        $twModel = new TwModel();
        $twAktif = $twModel->where('is_open', 1)->first();

        // 4. Total PIC aktif (indikator ditugaskan untuk ATASAN)
        $picModel = new PicModel();
        $totalPicAktif = $picModel
            ->where('user_id', $userId)
            ->countAllResults();

        // 5. Hitung status dokumen yang harus diverifikasi ATASAN berdasarkan unit/jurusan
$dokumenModel = new DokumenModel();

// Ambil Unit Atasan (bidang_id == unit_prodi AND unit_jurusan)
$unitAtasan = $atasan['bidang_id'];

// Pending (dokumen staff menunggu kaprodi/kajur)
$pending = $dokumenModel
    ->groupStart()
        ->where('status', 'pending_kaprodi')
        ->where('unit_asal_id', $unitAtasan)
    ->groupEnd()
    ->orGroupStart()
        ->where('status', 'pending_kajur')
        ->where('unit_jurusan_id', $unitAtasan)
    ->groupEnd()
    ->countAllResults();

// Approved (sudah disetujui sampai akhir)
$approved = $dokumenModel
    ->where('status', 'archived')
    ->groupStart()
        ->where('unit_asal_id', $unitAtasan)
        ->orWhere('unit_jurusan_id', $unitAtasan)
    ->groupEnd()
    ->countAllResults();

// Rejected (dikembalikan staff)
$rejected = $dokumenModel
    ->groupStart()
        ->where('status', 'rejected_kaprodi')
        ->where('unit_asal_id', $unitAtasan)
    ->groupEnd()
    ->orGroupStart()
        ->where('status', 'rejected_kajur')
        ->where('unit_jurusan_id', $unitAtasan)
    ->groupEnd()
    ->countAllResults();


        // 6. Notifikasi unread
        $notifModel = new NotificationModel();
        $notifikasi = $notifModel
            ->where('user_id', $userId)
            ->where('status', 'unread')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('atasan/dashboard', [
            'atasan'          => $atasan,
            'tahunAktif'      => $tahunAktif,
            'twAktif'         => $twAktif,
            'totalPicAktif'   => $totalPicAktif,
            'pending'         => $pending,
            'approved'        => $approved,
            'rejected'        => $rejected,
            'notifikasi'      => $notifikasi,
        ]);
    }
}
