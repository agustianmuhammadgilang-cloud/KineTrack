<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TahunAnggaranModel;

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
        $tahun  = $this->request->getPost('tahun');
        $status = $this->request->getPost('status');

        // 🔥 CEK TAHUN SUDAH ADA?
        $existing = $this->model->where('tahun', $tahun)->first();
        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'Tahun sudah ada!');
        }

        $this->model->insert([
            'tahun'  => $tahun,
            'status' => $status
        ]);

        return redirect()->to('/admin/tahun')->with('success', 'Tahun berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['tahun'] = $this->model->find($id);
        return view('admin/tahun/edit', $data);
    }

    public function update($id)
{
    $tahun  = $this->request->getPost('tahun');
    $status = $this->request->getPost('status');

    // 🔥 Validasi: Cek apakah tahun sudah ada di data lain (selain yg sedang diedit)
    $existing = $this->model
        ->where('tahun', $tahun)
        ->where('id !=', $id)
        ->first();

    if ($existing) {
        return redirect()->back()->withInput()->with('error', 'Tahun sudah tersedia!');
    }

    // Logika update asli (tidak diubah)
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
