<?php

namespace App\Controllers\Atasan;

use App\Controllers\BaseController;
use App\Models\LaporanModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $laporanModel = new LaporanModel();
        $userModel = new UserModel();

        // id bidang atasan
        $bidangAtasan = session('bidang_id');

        // ambil semua staff dalam bidang tersebut
        $staff = $userModel->where('bidang_id', $bidangAtasan)->findAll();
        $staffIds = array_column($staff, 'id');

        if (empty($staffIds)) {
            $data = [
                'pending' => 0,
                'approved' => 0,
                'rejected' => 0,
            ];
        } else {
            // hitung status laporan
            $data['pending'] = $laporanModel->whereIn('user_id', $staffIds)->where('status', 'pending')->countAllResults();
            $data['approved'] = $laporanModel->whereIn('user_id', $staffIds)->where('status', 'approved')->countAllResults();
            $data['rejected'] = $laporanModel->whereIn('user_id', $staffIds)->where('status', 'rejected')->countAllResults();
        }

        return view('atasan/dashboard', $data);
    }
}
