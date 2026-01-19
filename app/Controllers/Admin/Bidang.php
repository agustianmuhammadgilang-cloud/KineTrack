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
    $model = new \App\Models\BidangModel();

    $keyword = $this->request->getGet('q');

    // =============================
    // DEFAULT (tanpa search)
    // =============================
    if (!$keyword) {
        return view('admin/bidang/index', [
            'jurusan' => $model->where('jenis_unit', 'jurusan')->findAll(),
            'prodi'   => $model->where('jenis_unit', 'prodi')->findAll(),
            'keyword' => null
        ]);
    }

    // =============================
    // SEARCH MODE
    // =============================

    // 1. Cari jurusan yang match keyword
    $jurusanMatch = $model
        ->where('jenis_unit', 'jurusan')
        ->like('nama_bidang', $keyword)
        ->findAll();

    // Ambil ID jurusan yang match
    $jurusanIds = array_column($jurusanMatch, 'id');

    // 2. Cari prodi yang match keyword
    $prodiMatch = $model
        ->where('jenis_unit', 'prodi')
        ->like('nama_bidang', $keyword)
        ->findAll();

    // Ambil parent_id dari prodi yang match
    $parentIdsFromProdi = array_unique(array_column($prodiMatch, 'parent_id'));

    // 3. Gabungkan jurusan:
    // - jurusan hasil search langsung
    // - jurusan induk dari prodi yang match
    $allJurusanIds = array_unique(array_merge($jurusanIds, $parentIdsFromProdi));

    $jurusanFinal = [];
    if (!empty($allJurusanIds)) {
        $jurusanFinal = $model
            ->where('jenis_unit', 'jurusan')
            ->whereIn('id', $allJurusanIds)
            ->findAll();
    }

    // 4. Ambil prodi:
    // - prodi di bawah jurusan yang tampil
    // - ATAU prodi hasil search langsung
    $prodiFinal = [];

    if (!empty($allJurusanIds)) {
        $prodiFinal = $model
            ->where('jenis_unit', 'prodi')
            ->whereIn('parent_id', $allJurusanIds)
            ->findAll();
    }

    return view('admin/bidang/index', [
        'jurusan' => $jurusanFinal,
        'prodi'   => $prodiFinal,
        'keyword' => $keyword
    ]);
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
