<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BidangModel;
use App\Models\NotificationModel;
use App\Models\UserModel;

class Bidang extends BaseController
{
    public function index()
    {
        $model = new BidangModel();
        $data['bidang'] = $model->findAll();
        return view('admin/bidang/index', $data);
    }

    public function create()
    {
        return view('admin/bidang/create');
    }

    public function store()
    {
        $model = new BidangModel();
        $nama = $this->request->getPost('nama_bidang');

        $model->insert([
            'nama_bidang' => $nama
        ]);

        // ======= NOTIFIKASI STAFF =======
        $notificationModel = new NotificationModel();
        $staffUsers = (new UserModel())->where('role','staff')->findAll();
        foreach ($staffUsers as $staff) {
            $notificationModel->insert([
                'user_id' => $staff['id'],
                'title'   => 'Bidang Baru Ditambahkan',
                'message' => "Admin menambahkan bidang baru: $nama",
                'type'    => 'success',
                'is_read' => 0
            ]);
        }

        return redirect()->to('/admin/bidang')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $model = new BidangModel();
        $data['bidang'] = $model->find($id);
        return view('admin/bidang/edit', $data);
    }

    public function update($id)
    {
        $model = new BidangModel();
        $model->update($id, [
            'nama_bidang' => $this->request->getPost('nama_bidang')
        ]);

        return redirect()->to('/admin/bidang')->with('success', 'Data berhasil diupdate');
    }

    public function delete($id)
    {
        $model = new BidangModel();
        $model->delete($id);

        return redirect()->to('/admin/bidang')->with('success', 'Data berhasil dihapus');
    }
}
