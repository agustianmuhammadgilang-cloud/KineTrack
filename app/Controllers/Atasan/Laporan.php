<?php

namespace App\Controllers\Atasan;

use App\Controllers\BaseController;
use App\Models\LaporanModel;
use App\Models\UserModel;

class Laporan extends BaseController
{
    public function index()
    {
        $laporanModel = new LaporanModel();
        $userModel = new UserModel();

        // ambil bidang atasan
        $bidangAtasan = session('bidang_id');

        // ambil semua user staff dalam bidang yang sama
        $userStaff = $userModel->where('bidang_id', $bidangAtasan)->findAll();
        $staffIds = array_column($userStaff, 'id');

        if (empty($staffIds)) {
            $data['laporan'] = [];
        } else {
            $data['laporan'] = $laporanModel
                ->whereIn('user_id', $staffIds)
                ->orderBy('id', 'DESC')
                ->findAll();
        }

        return view('atasan/laporan/index', $data);
    }

    public function detail($id)
    {
        $laporanModel = new LaporanModel();

        $data['lap'] = $laporanModel
            ->select('laporan.*, users.nama')
            ->join('users', 'users.id = laporan.user_id')
            ->find($id);

        return view('atasan/laporan/detail', $data);
    }

    public function approve($id)
    {
        $model = new LaporanModel();

        $model->update($id, [
            'status' => 'approved',
            'catatan_atasan' => null
        ]);

        return redirect()->to('/atasan/laporan')->with('success', 'Laporan disetujui!');
    }

    public function reject($id)
    {
        $model = new LaporanModel();

        $catatan = $this->request->getPost('catatan');

        $model->update($id, [
            'status' => 'rejected',
            'catatan_atasan' => $catatan
        ]);

        return redirect()->to('/atasan/laporan')->with('success', 'Laporan ditolak.');
    }
}
