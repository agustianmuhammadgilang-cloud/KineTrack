<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengajuanKategoriModel;
use App\Models\KategoriDokumenModel;

class PengajuanKategori extends BaseController
{
    protected $pengajuanModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->pengajuanModel = new PengajuanKategoriModel();
        $this->kategoriModel  = new KategoriDokumenModel();
    }

    public function index()
    {
        $data['pengajuan'] = $this->pengajuanModel
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('admin/pengajuan_kategori/index', $data);
    }

    // ============================
    // APPROVE
    // ============================
    public function approve($id)
    {
        $pengajuan = $this->pengajuanModel->find($id);

        if (!$pengajuan || $pengajuan['status'] !== 'pending') {
            return redirect()->back()->with('error', 'Pengajuan tidak valid');
        }

        // buat kategori baru
        $this->kategoriModel->insert([
            'nama_kategori' => $pengajuan['nama_kategori'],
            'deskripsi'     => $pengajuan['deskripsi'],
            'status'        => 'aktif',
            'created_by'    => session()->get('user_id')
        ]);

        // update status pengajuan
        $this->pengajuanModel->update($id, [
            'status'   => 'approved',
            'admin_id' => session()->get('user_id')
        ]);

        return redirect()->back()
            ->with('success', 'Pengajuan disetujui & kategori dibuat');
    }

    // ============================
    // REJECT
    // ============================
    public function reject($id)
    {
        $pengajuan = $this->pengajuanModel->find($id);

        if (!$pengajuan || $pengajuan['status'] !== 'pending') {
            return redirect()->back()->with('error', 'Pengajuan tidak valid');
        }

        $this->pengajuanModel->update($id, [
            'status'   => 'rejected',
            'admin_id' => session()->get('user_id')
        ]);

        return redirect()->back()
            ->with('success', 'Pengajuan ditolak');
    }
}
