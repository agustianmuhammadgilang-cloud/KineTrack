<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengajuanKategoriModel;
use App\Models\KategoriDokumenModel;
// Controller untuk mengelola pengajuan kategori dokumen
class PengajuanKategori extends BaseController
{
    protected $pengajuanModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->pengajuanModel = new PengajuanKategoriModel();
        $this->kategoriModel  = new KategoriDokumenModel();
    }
// ============================
// LIST PENGAJUAN KATEGORI
// ============================
    public function index()
    {
        $data['pengajuan'] = array_map(function ($row) {

    // NORMALISASI STATUS
    if (empty($row['status'])) {
        $row['status'] = 'pending';
    }

    return $row;

}, $this->pengajuanModel
        ->orderBy('created_at', 'DESC')
        ->findAll());


        return view('admin/pengajuan_kategori/index', $data);
    }

    // ============================
    // APPROVE
    // ============================
    public function approve($id)
{
    $pengajuan = $this->pengajuanModel->find($id);

    if (!$pengajuan) {
        return redirect()->back()->with('error', 'Pengajuan tidak ditemukan');
    }

    if (in_array($pengajuan['status'], ['approved', 'rejected'])) {
        return redirect()->back()->with('error', 'Pengajuan sudah diproses');
    }

    //  cari kategori existing
    $kategori = $this->kategoriModel
        ->where('nama_kategori', $pengajuan['nama_kategori'])
        ->first();

    if (!$kategori) {
        return redirect()->back()->with('error', 'Kategori tidak ditemukan');
    }

    //  AKTIFKAN kategori
    $this->kategoriModel->update($kategori['id'], [
        'status' => 'aktif'
    ]);

    // update status pengajuan
    $this->pengajuanModel->update($id, [
        'status'   => 'approved',
        'admin_id' => session()->get('user_id')
    ]);

    // =====================
    // LOG AKTIVITAS ADMIN
    // =====================
    log_activity(
        'approve_pengajuan_kategori',
        'Menyetujui pengajuan kategori dokumen: ' . $kategori['nama_kategori'],
        'kategori_dokumen',
        $kategori['id']
    );

    return redirect()->back()
        ->with('success', 'Kategori berhasil divalidasi');
}


    // ============================
    // REJECT
    // ============================
    public function reject($id)
{
    $pengajuan = $this->pengajuanModel->find($id);

    if (!$pengajuan) {
        return redirect()->back()->with('error', 'Pengajuan tidak ditemukan');
    }

    if (in_array($pengajuan['status'], ['approved', 'rejected'])) {
        return redirect()->back()->with('error', 'Pengajuan sudah diproses');
    }

    //  CARI KATEGORI YANG SUDAH DIBUAT STAFF
    $kategori = $this->kategoriModel
        ->where('nama_kategori', $pengajuan['nama_kategori'])
        ->first();

    if (!$kategori) {
        return redirect()->back()->with('error', 'Kategori tidak ditemukan');
    }

    //  UPDATE STATUS KATEGORI (BUKAN INSERT)
    $this->kategoriModel->update($kategori['id'], [
        'status' => 'rejected'
    ]);

    // update histori pengajuan
    $this->pengajuanModel->update($id, [
        'status'   => 'rejected',
        'admin_id' => session()->get('user_id')
    ]);


    // =====================
    // LOG AKTIVITAS ADMIN
    // =====================
    log_activity(
        'reject_pengajuan_kategori',
        'Menolak pengajuan kategori dokumen: ' . $kategori['nama_kategori'],
        'kategori_dokumen',
        $kategori['id']
    );

    return redirect()->back()
        ->with('success', 'Pengajuan ditolak');
}



}