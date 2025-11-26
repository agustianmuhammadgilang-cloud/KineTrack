<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\JabatanModel;
use App\Models\BidangModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $user = new UserModel();
        $jabatan = new JabatanModel();
        $bidang = new BidangModel();

        $data = [
            'total_user'    => $user->countAllResults(),
            'total_jabatan' => $jabatan->countAllResults(),
            'total_bidang'  => $bidang->countAllResults()
        ];

        return view('admin/dashboard', $data);
    }
}
