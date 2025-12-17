<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JabatanModel;

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
    $namaJabatan = $this->request->getPost('nama_jabatan');
    $defaultRole = $this->detectDefaultRole($namaJabatan);

    $model = new JabatanModel();
    $model->insert([
        'nama_jabatan' => $namaJabatan,
        'default_role' => $defaultRole
    ]);

    return redirect()->to('/admin/jabatan')
        ->with('success', 'Jabatan berhasil ditambahkan (role default: '.$defaultRole.')');
}

    public function edit($id)
    {
        $model = new JabatanModel();
        $data['jabatan'] = $model->find($id);
        return view('admin/jabatan/edit', $data);
    }

    public function update($id)
{
    $namaJabatan = $this->request->getPost('nama_jabatan');
    $defaultRole = $this->detectDefaultRole($namaJabatan);

    $model = new JabatanModel();
    $model->update($id, [
        'nama_jabatan' => $namaJabatan,
        'default_role' => $defaultRole
    ]);

    return redirect()->to('/admin/jabatan')
        ->with('success', 'Jabatan berhasil diupdate (role default: '.$defaultRole.')');
}
    public function delete($id)
    {
        $model = new JabatanModel();
        $model->delete($id);

        return redirect()->to('/admin/jabatan')->with('success', 'Data berhasil dihapus');
    }

    private function detectDefaultRole(string $namaJabatan): string
{
    $nama = strtolower($namaJabatan);

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
