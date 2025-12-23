<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriDokumenModel;

class KategoriDokumen extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriDokumenModel();
    }

    // ============================
    // LIST KATEGORI
    // ============================
    public function index()
    {
        $data = [
            'title'    => 'Kategori Dokumen',
            'kategori' => $this->kategoriModel->findAll()
        ];

        return view('admin/kategori/index', $data);
    }

    // ============================
    // FORM TAMBAH
    // ============================
    public function create()
    {
        return view('admin/kategori/create', [
            'title' => 'Tambah Kategori Dokumen'
        ]);
    }

    // ============================
    // SIMPAN
    // ============================
    public function store()
{
    $this->kategoriModel->insert([
        'nama_kategori' => $this->request->getPost('nama_kategori'),
        'deskripsi'     => $this->request->getPost('deskripsi'),
        'status'        => 'aktif',
        'created_by'    => session()->get('user_id')
    ]);

    return redirect()->to('/admin/kategori-dokumen')
                     ->with('success', 'Kategori berhasil ditambahkan');
}


    // ============================
    // FORM EDIT
    // ============================
    public function edit($id)
    {
        $kategori = $this->kategoriModel->find($id);

        if (!$kategori) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }

        return view('admin/kategori/edit', [
            'title'    => 'Edit Kategori Dokumen',
            'kategori' => $kategori
        ]);
    }

    // ============================
    // UPDATE
    // ============================
    public function update($id)
    {
        $this->kategoriModel->update($id, [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'deskripsi'     => $this->request->getPost('deskripsi')
        ]);

        return redirect()->to('/admin/kategori-dokumen')
                         ->with('success', 'Kategori berhasil diperbarui');
    }

    // ============================
    // AKTIF / NONAKTIF
    // ============================
    public function toggleStatus($id)
    {
        $kategori = $this->kategoriModel->find($id);

        if (!$kategori) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $statusBaru = $kategori['status'] === 'aktif' ? 'nonaktif' : 'aktif';

        $this->kategoriModel->update($id, [
            'status' => $statusBaru
        ]);

        return redirect()->back()
                         ->with('success', 'Status kategori diperbarui');
    }

    
}
