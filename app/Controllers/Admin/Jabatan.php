<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JabatanModel;
// Controller untuk mengelola jabatan
class Jabatan extends BaseController
{
    // Menampilkan daftar jabatan
    public function index()
    {
        $model = new JabatanModel();
        $data['jabatan'] = $model->findAll();
        return view('admin/jabatan/index', $data);
    }
    // Menampilkan form untuk menambahkan jabatan baru
    public function create()
    {
        return view('admin/jabatan/create');
    }
// Menyimpan jabatan baru
    public function store()
{
    $namaJabatan = $this->request->getPost('nama_jabatan');
    $defaultRole = $this->detectDefaultRole($namaJabatan);

    $model = new JabatanModel();
    $id = $model->insert([
    'nama_jabatan' => $namaJabatan,
    'default_role' => $defaultRole
]);
// LOG AKTIVITAS
log_activity(
    'create_jabatan',
    'Menambahkan jabatan: ' . $namaJabatan,
    'jabatan',
    $id
);

    return redirect()->to('/admin/jabatan')
        ->with('success', 'Jabatan berhasil ditambahkan (role default: '.$defaultRole.')');
}
// Menampilkan form untuk mengedit jabatan
    public function edit($id)
    {
        $model = new JabatanModel();
        $data['jabatan'] = $model->find($id);
        return view('admin/jabatan/edit', $data);
    }
// Memperbarui jabatan
    public function update($id)
{
    $namaJabatan = $this->request->getPost('nama_jabatan');
    $defaultRole = $this->detectDefaultRole($namaJabatan);

    $model = new JabatanModel();
    $model->update($id, [
        'nama_jabatan' => $namaJabatan,
        'default_role' => $defaultRole
    ]);
// LOG AKTIVITAS
    log_activity(
    'update_jabatan',
    'Mengubah jabatan: ' . $namaJabatan,
    'jabatan',
    $id
);

    return redirect()->to('/admin/jabatan')
        ->with('success', 'Jabatan berhasil diupdate (role default: '.$defaultRole.')');
}
// Menghapus jabatan
    public function delete($id)
    {
        $model = new JabatanModel();
        $jabatan = $model->find($id);

if ($jabatan) {
    // LOG AKTIVITAS
    log_activity(
        'delete_jabatan',
        'Menghapus jabatan: ' . $jabatan['nama_jabatan'],
        'jabatan',
        $id
    );
}

$model->delete($id);


        

        return redirect()->to('/admin/jabatan')->with('success', 'Data berhasil dihapus');
    }
// Fungsi untuk mendeteksi default role berdasarkan nama jabatan
private function detectDefaultRole(string $namaJabatan): string
{
    $nama = strtolower($namaJabatan);

    // 🔥 TAMBAHAN KHUSUS PIMPINAN (TIDAK MENGGANGGU LOGIKA LAMA)
    if (str_contains($nama, 'pimpinan')) {
        return 'pimpinan';
    }

    // LOGIKA LAMA (TETAP UTUH)
    if (
        str_contains($nama, 'ketua') ||
        str_contains($nama, 'kepala') ||
        str_contains($nama, 'koordinator')
    ) {
        return 'atasan';
    }

    if (
        str_contains($nama, 'staff') ||
        str_contains($nama, 'pelaksana')
    ) {
        return 'staff';
    }

    return 'staff';
}

}
