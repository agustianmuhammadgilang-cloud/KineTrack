<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BidangModel;
// Controller untuk mengelola unit kerja (bidang)
class Bidang extends BaseController
{
    // Menampilkan daftar unit kerja
    public function index()
    {
        $model = new BidangModel();

        $data['jurusan'] = $model->where('jenis_unit', 'jurusan')->findAll();
        $data['prodi']   = $model->where('jenis_unit', 'prodi')->findAll();

        return view('admin/bidang/index', $data);
    }
    // Menampilkan form untuk menambahkan unit kerja baru
    public function create()
    {
        $model = new BidangModel();
        $data['jurusan'] = $model->where('jenis_unit', 'jurusan')->findAll();

        return view('admin/bidang/create', $data);
    }
    // Menyimpan unit kerja baru
    public function store()
    {
        $model = new BidangModel();

        $nama_bidang = $this->request->getPost('nama_bidang');
        $jenis_unit  = $this->request->getPost('jenis_unit');
        $parent_id   = $this->request->getPost('parent_id');

        // VALIDASI SERVER SIDE
        if ($jenis_unit === 'prodi' && empty($parent_id)) {
            return redirect()->back()->withInput()->with('error', 'Harap pilih Jurusan induk untuk Prodi.');
        }

        $id = $model->insert([
    'nama_bidang' => $nama_bidang,
    'jenis_unit'  => $jenis_unit,
    'parent_id'   => $jenis_unit === 'prodi' ? $parent_id : null
]);
// LOG AKTIVITAS
log_activity(
    'create_bidang',
    'Menambahkan unit kerja: ' . $nama_bidang,
    'bidang',
    $id
);


        return redirect()->to('/admin/bidang')->with('success', 'Unit Kerja berhasil ditambahkan');
    }
// Menampilkan form untuk mengedit unit kerja
    public function edit($id)
    {
        $model = new BidangModel();
        $data['bidang']  = $model->find($id);
        $data['jurusan'] = $model->where('jenis_unit', 'jurusan')->findAll();

        return view('admin/bidang/edit', $data);
    }
// Memperbarui unit kerja
    public function update($id)
    {
        $model = new BidangModel();

        $nama_bidang = $this->request->getPost('nama_bidang');
        $jenis_unit  = $this->request->getPost('jenis_unit');
        $parent_id   = $this->request->getPost('parent_id');

        // VALIDASI
        if ($jenis_unit === 'prodi' && empty($parent_id)) {
            return redirect()->back()->withInput()->with('error', 'Harap pilih Jurusan induk untuk Prodi.');
        }

        $model->update($id, [
    'nama_bidang' => $nama_bidang,
    'jenis_unit'  => $jenis_unit,
    'parent_id'   => $jenis_unit === 'prodi' ? $parent_id : null
]);
// LOG AKTIVITAS
log_activity(
    'update_bidang',
    'Mengubah unit kerja: ' . $nama_bidang,
    'bidang',
    $id
);


        return redirect()->to('/admin/bidang')->with('success', 'Unit Kerja berhasil diupdate');
    }
// Menghapus unit kerja
    public function delete($id)
    {
        $model = new BidangModel();
        $bidang = $model->find($id);
$model->delete($id);
// LOG AKTIVITAS
log_activity(
    'delete_bidang',
    'Menghapus unit kerja: ' . ($bidang['nama_bidang'] ?? 'unknown'),
    'bidang',
    $id
);


        return redirect()->to('/admin/bidang')->with('success', 'Unit Kerja berhasil dihapus');
    }
}
