<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TahunAnggaranModel;
use App\Models\NotificationModel;
use App\Models\UserModel;

class TahunAnggaran extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new TahunAnggaranModel();
    }

    public function index()
    {
        $data['tahun'] = $this->model->orderBy('tahun', 'DESC')->findAll();
        return view('admin/tahun/index', $data);
    }

    public function create()
    {
        return view('admin/tahun/create');
    }

    public function store()
    {
        $tahun = $this->request->getPost('tahun');
        $status = $this->request->getPost('status');

        $this->model->insert([
            'tahun'  => $tahun,
            'status' => $status
        ]);

        // ======= NOTIFIKASI STAFF =======
        $notificationModel = new NotificationModel();
        $staffUsers = (new UserModel())->where('role','staff')->findAll();
        foreach ($staffUsers as $staff) {
            $notificationModel->insert([
                'user_id' => $staff['id'],
                'title'   => 'Tahun Anggaran Ditambahkan',
                'message' => "Admin menambahkan Tahun Anggaran baru: $tahun",
                'type'    => 'success',
                'is_read' => 0
            ]);
        }

        return redirect()->to('/admin/tahun')->with('success', 'Tahun berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['tahun'] = $this->model->find($id);
        return view('admin/tahun/edit', $data);
    }

    public function update($id)
    {
        $tahun = $this->request->getPost('tahun');
        $status = $this->request->getPost('status');

        $this->model->update($id, [
            'tahun'  => $tahun,
            'status' => $status,
        ]);

        return redirect()->to('/admin/tahun')->with('success', 'Tahun berhasil diupdate');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/tahun')->with('success', 'Tahun berhasil dihapus');
    }
}
