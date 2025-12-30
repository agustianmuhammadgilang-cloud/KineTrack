<?php

namespace App\Controllers\Atasan;

use App\Controllers\BaseController;
use App\Models\LaporanModel;
use App\Models\UserModel;
// Controller untuk menampilkan dashboard atasan
class Dashboard extends BaseController
{
    // Menampilkan halaman dashboard
   public function index()
{
    $laporanModel = new LaporanModel();
    $userModel = new UserModel();

    $atasan = $userModel
        ->select('users.*, jabatan.nama_jabatan, bidang.nama_bidang')
        ->join('jabatan', 'jabatan.id = users.jabatan_id', 'left')
        ->join('bidang', 'bidang.id = users.bidang_id', 'left')
        ->find(session('user_id'));

    // bidang atasan
    $bidangAtasan = session('bidang_id');
    $staff = $userModel->where('bidang_id', $bidangAtasan)->findAll();
    $staffIds = array_column($staff, 'id');

    if (empty($staffIds)) {
        $data = [
            'atasan' => $atasan,
            'pending' => 0,
            'approved' => 0,
            'rejected' => 0,
        ];
    } else {
        $data = [
            'atasan' => $atasan,
            'pending'  => $laporanModel->whereIn('user_id', $staffIds)->where('status', 'pending')->countAllResults(),
            'approved' => $laporanModel->whereIn('user_id', $staffIds)->where('status', 'approved')->countAllResults(),
            'rejected' => $laporanModel->whereIn('user_id', $staffIds)->where('status', 'rejected')->countAllResults(),
        ];
    }

    return view('atasan/dashboard', $data);
}

}
