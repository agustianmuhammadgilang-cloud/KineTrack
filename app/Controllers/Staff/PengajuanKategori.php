<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\PengajuanKategoriModel;

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

        $this->pengajuanModel->insert([
            'nama_kategori'   => $nama,
            'deskripsi'       => $this->request->getPost('deskripsi'),
            'pengaju_user_id' => $userId,
            'status'          => 'pending'
        ]);

        return redirect()->to('/staff/dokumen/create')
            ->with('success', 'Pengajuan kategori berhasil dikirim, menunggu persetujuan admin');
    }
}
