<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\PengajuanKategoriModel;
use App\Models\KategoriDokumenModel;

// Controller untuk mengelola pengajuan kategori dokumen oleh staff
class PengajuanKategori extends BaseController
{
    protected $pengajuanModel;
    // Konstruktor untuk inisialisasi model pengajuan kategori
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
        // Catat aktivitas membuka form pengajuan
        log_activity(
    'open_pengajuan_kategori',
    'Membuka form pengajuan kategori dokumen',
    'kategori_dokumen',
    null
);

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

    // CEK APAKAH KATEGORI SUDAH ADA
    $exists = $kategoriModel
        ->where('LOWER(nama_kategori)', strtolower($nama))
        ->first();

    if ($exists) {
        return redirect()->back()
            ->with('error', 'Kategori sudah ada dan bisa langsung digunakan');
    }

    // SIMPAN KATEGORI DENGAN STATUS PENDING
    $kategoriModel->insert([
        'nama_kategori' => $nama,
        'deskripsi'     => $this->request->getPost('deskripsi'),
        'status'        => 'pending', 
        'created_by'    => $userId
    ]);

    // SIMPAN PENGAJUAN UNTUK TRACKING
$this->pengajuanModel->insert([
    'nama_kategori'   => $nama,
    'deskripsi'       => $this->request->getPost('deskripsi'),
    'pengaju_user_id' => $userId,
    'status'          => 'pending' 
]);
// LOG AKTIVITAS PENGAJUAN
log_activity(
    'submit_pengajuan_kategori',
    "Mengajukan kategori dokumen baru: {$nama}",
    'kategori_dokumen',
    null
);



    return redirect()->to('/staff/dokumen/create')
        ->with('success', 'Kategori berhasil dibuat dan dapat langsung digunakan');
}

}
