<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengajuanKategoriModel;
use App\Models\KategoriDokumenModel;
use App\Models\NotificationModel;
// Controller untuk mengelola pengajuan kategori dokumen
class PengajuanKategori extends BaseController
{
    protected $pengajuanModel;
    protected $kategoriModel;
    protected $notifModel;

    public function __construct()
    {
        $this->pengajuanModel = new PengajuanKategoriModel();
        $this->kategoriModel  = new KategoriDokumenModel();
        $this->notifModel     = new NotificationModel();
    }
// ============================
// LIST PENGAJUAN KATEGORI
// ============================
public function index()
{
    $status = $this->request->getGet('status');

    $query = $this->pengajuanModel->orderBy('created_at', 'DESC');

    if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
        $query->where('status', $status);
    }

    $data = [
        'pengajuan' => array_map(function ($row) {
            if (empty($row['status'])) {
                $row['status'] = 'pending';
            }
            return $row;
        }, $query->findAll()),

        'statusFilter' => $status
    ];

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

    $this->notifModel->insert([
    'user_id' => $pengajuan['pengaju_user_id'],
    'message' => 'Pengajuan kategori "' . $pengajuan['nama_kategori'] . '" telah disetujui dan siap digunakan.',
    'meta' => json_encode([
        'type' => 'pengajuan_kategori',
        'status' => 'approved'
    ]),
    'status' => 'unread',
    'created_at' => date('Y-m-d H:i:s')
]);

$this->notifModel->insert([
    'user_id' => session()->get('user_id'),
    'message' => 'Anda berhasil menyetujui pengajuan kategori "' . $pengajuan['nama_kategori'] . '".',
    'meta' => json_encode([
        'type' => 'pengajuan_kategori',
        'action' => 'approve'
    ]),
    'status' => 'unread',
    'created_at' => date('Y-m-d H:i:s')
]);


    return redirect()->back();
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

    $this->notifModel->insert([
    'user_id' => $pengajuan['pengaju_user_id'],
    'message' => 'Pengajuan kategori "' . $pengajuan['nama_kategori'] . '" ditolak oleh admin.',
    'meta' => json_encode([
        'type' => 'pengajuan_kategori',
        'status' => 'rejected'
    ]),
    'status' => 'unread',
    'created_at' => date('Y-m-d H:i:s')
]);


$this->notifModel->insert([
    'user_id' => session()->get('user_id'),
    'message' => 'Anda berhasil menolak pengajuan kategori "' . $pengajuan['nama_kategori'] . '".',
    'meta' => json_encode([
        'type' => 'pengajuan_kategori',
        'action' => 'reject'
    ]),
    'status' => 'unread',
    'created_at' => date('Y-m-d H:i:s')
]);


    return redirect()->back();
}



}