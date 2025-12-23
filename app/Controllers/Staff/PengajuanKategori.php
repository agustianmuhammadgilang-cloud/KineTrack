<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\PengajuanKategoriModel;
use App\Models\KategoriDokumenModel;

class PengajuanKategori extends BaseController
{
    protected $pengajuanModel;

    public function __construct()
    {
        $this->pengajuanModel = new PengajuanKategoriModel();
    }

    /**
     * ============================
     * FORM AJUKAN KATEGORI
     * ============================
     */
    public function create()
    {
        return view('staff/kategori/ajukan');
    }

    /**
     * ============================
     * SIMPAN PENGAJUAN
     * ============================
     */

public function store()
{
    $userId = session()->get('user_id');
    if (!$userId) {
        return redirect()->to('/login');
    }

    $nama = trim($this->request->getPost('nama_kategori'));
    if (!$nama) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Nama kategori wajib diisi');
    }

    $kategoriModel = new KategoriDokumenModel();

    // 🔥 CEGAH DUPLIKASI NAMA
    $exists = $kategoriModel
        ->where('LOWER(nama_kategori)', strtolower($nama))
        ->first();

    if ($exists) {
        return redirect()->back()
            ->with('error', 'Kategori sudah ada dan bisa langsung digunakan');
    }

    // ✅ LANGSUNG BUAT KATEGORI (BELUM TERVALIDASI)
    $kategoriModel->insert([
        'nama_kategori' => $nama,
        'deskripsi'     => $this->request->getPost('deskripsi'),
        'status'        => 'pending', // ⬅️ KUNCI
        'created_by'    => $userId
    ]);

    // (opsional) simpan histori pengajuan
$this->pengajuanModel->insert([
    'nama_kategori'   => $nama,
    'deskripsi'       => $this->request->getPost('deskripsi'),
    'pengaju_user_id' => $userId,
    'status'          => 'pending' // 🔑 BUKAN approved_auto
]);


    return redirect()->to('/staff/dokumen/create')
        ->with('success', 'Kategori berhasil dibuat dan dapat langsung digunakan');
}

}
