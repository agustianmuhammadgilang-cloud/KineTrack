<?php

namespace App\Controllers\Atasan;

use App\Controllers\BaseController;
use App\Models\LaporanModel;
use App\Models\UserModel;

class Notifications extends BaseController
{
    /**
     * Return JSON { pending: X }
     * counts pending laporan for staff in the same bidang as logged-in atasan
     */
    public function pendingCount()
    {
        helper('text');
        $laporanModel = new LaporanModel();
        $userModel = new UserModel();

        $bidangAtasan = session('bidang_id');

        // if no bidang in session, return zero
        if (empty($bidangAtasan)) {
            return $this->response->setJSON(['pending' => 0]);
        }

        // find staff ids in same bidang
        $staff = $userModel->where('bidang_id', $bidangAtasan)->where('role', 'staff')->findAll();
        $staffIds = array_column($staff, 'id');

        if (empty($staffIds)) {
            return $this->response->setJSON(['pending' => 0]);
        }

        $count = $laporanModel->whereIn('user_id', $staffIds)
                              ->where('status', 'pending')
                              ->countAllResults();

        return $this->response->setJSON(['pending' => (int) $count]);
    }

    /**
     * Optional: return array of pending laporan summary (id, judul, nama, tanggal)
     */
    public function list()
    {
        $laporanModel = new LaporanModel();
        $userModel = new UserModel();

        $bidangAtasan = session('bidang_id');

        if (empty($bidangAtasan)) {
            return $this->response->setJSON(['items' => []]);
        }

        $staff = $userModel->where('bidang_id', $bidangAtasan)->where('role', 'staff')->findAll();
        $staffIds = array_column($staff, 'id');
        if (empty($staffIds)) {
            return $this->response->setJSON(['items' => []]);
        }

        $items = $laporanModel
            ->select('laporan.id, laporan.judul, laporan.tanggal, users.nama as staff_nama')
            ->join('users', 'users.id = laporan.user_id')
            ->whereIn('user_id', $staffIds)
            ->where('status', 'pending')
            ->orderBy('laporan.created_at', 'DESC')
            ->findAll();

        return $this->response->setJSON(['items' => $items]);
    }
}
