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
    $data = [
        'nama_kategori' => $this->request->getPost('nama_kategori'),
        'deskripsi'     => $this->request->getPost('deskripsi'),
        'status'        => 'aktif',
        'created_by'    => session()->get('user_id')
    ];

    $kategoriId = $this->kategoriModel->insert($data);

    // ✅ LOG AKTIVITAS
    log_activity(
        'create_kategori_dokumen',
        "Menambahkan kategori dokumen '{$data['nama_kategori']}'",
        'kategori_dokumen',
        $kategoriId
    );

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

        $this->kategoriModel->update($id, $dataBaru);

        // ✅ LOG AKTIVITAS
    log_activity(
        'update_kategori_dokumen',
        'Memperbarui kategori dokumen dari "' . $kategoriLama['nama_kategori'] .
        '" menjadi "' . $dataBaru['nama_kategori'] . '"',
        'kategori_dokumen',
        $id
    );

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

    if ($kategori['status'] !== 'aktif' && $kategori['status'] !== 'nonaktif') {
        return redirect()->back()
            ->with('error', 'Kategori ini tidak bisa diubah statusnya');
    }

    $statusBaru = $kategori['status'] === 'aktif' ? 'nonaktif' : 'aktif';

    $this->kategoriModel->update($id, [
        'status' => $statusBaru
    ]);

    // ✅ LOG AKTIVITAS
    log_activity(
        'toggle_kategori_dokumen',
        'Mengubah status kategori dokumen "' . $kategori['nama_kategori'] .
        '" menjadi ' . strtoupper($statusBaru),
        'kategori_dokumen',
        $id
    );

    return redirect()->back()
        ->with('success', 'Status kategori diperbarui');
}



    
}
