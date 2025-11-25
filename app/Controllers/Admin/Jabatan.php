<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JabatanModel;
use App\Models\NotificationModel;
use App\Models\UserModel;

class Jabatan extends BaseController
{
    public function index()
    {
        $model = new JabatanModel();
        $data['jabatan'] = $model->findAll();
        return view('admin/jabatan/index', $data);
    }

    public function create()
    {
        return view('admin/jabatan/create');
    }

    public function store()
    {
        $model = new JabatanModel();
        $nama = $this->request->getPost('nama_jabatan');

        $model->insert([
            'nama_jabatan' => $nama
        ]);

        // ======= NOTIFIKASI STAFF =======
        $notificationModel = new NotificationModel();
        $staffUsers = (new UserModel())->where('role','staff')->findAll();
        foreach ($staffUsers as $staff) {
            $notificationModel->insert([
                'user_id' => $staff['id'],
                'title'   => 'Jabatan Baru Ditambahkan',
                'message' => "Admin menambahkan jabatan baru: $nama",
                'type'    => 'success',
                'is_read' => 0
            ]);
        }

        return redirect()->to('/admin/jabatan')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $model = new JabatanModel();
        $data['jabatan'] = $model->find($id);
        return view('admin/jabatan/edit', $data);
    }

    public function update($id)
    {
        $model = new JabatanModel();
        $model->update($id, [
            'nama_jabatan' => $this->request->getPost('nama_jabatan')
        ]);

        return redirect()->to('/admin/jabatan')->with('success', 'Data berhasil diupdate');
    }

    public function delete($id)
    {
        $model = new JabatanModel();
        $model->delete($id);

        return redirect()->to('/admin/jabatan')->with('success', 'Data berhasil dihapus');
    }
}
