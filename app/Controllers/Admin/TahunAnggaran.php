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

        $tahunId = $this->model->insert([
        'tahun'  => $tahun,
        'status' => $status
    ]);

    // ✅ LOG
    log_activity(
        'create_tahun',
        'Menambahkan tahun anggaran ' . $tahun,
        'tahun_anggaran',
        $tahunId
    );


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

    // 🔥 Validasi: Cek apakah tahun sudah ada di data lain
    $existing = $this->model
        ->where('tahun', $tahun)
        ->where('id !=', $id)
        ->first();

    if ($existing) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Tahun sudah tersedia!');
    }

    // Update status (aktif / nonaktif)
    $this->model->update($id, [
        'tahun'  => $tahun,
        'status' => $status,
    ]);

    // ✅ LOG AKTIVITAS (JELAS & AUDITABLE)
    $statusText = $status === 'active'
        ? 'Mengaktifkan tahun anggaran ' . $tahun
        : 'Menonaktifkan tahun anggaran ' . $tahun;

    log_activity(
        'update_tahun_status',
        $statusText,
        'tahun_anggaran',
        $id
    );

    return redirect()->to('/admin/tahun')
        ->with('success', 'Status tahun anggaran berhasil diperbarui');
}



    public function delete($id)
{
    $tahun = $this->model->find($id);

    $this->model->delete($id);

    // ✅ LOG
    log_activity(
        'delete_tahun',
        'Menghapus tahun anggaran ' . $tahun['tahun'],
        'tahun_anggaran',
        $id
    );

    return redirect()->to('/admin/tahun')->with('success', 'Tahun berhasil dihapus');
}

}
