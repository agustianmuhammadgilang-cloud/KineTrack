<?php

namespace App\Controllers\Atasan;

use App\Controllers\BaseController;
use App\Models\DokumenModel;
use App\Models\BidangModel;
// Controller untuk mengelola dokumen oleh atasan (kaprodi/kajur)
class Dokumen extends BaseController
{
    protected $dokumenModel;
    protected $bidangModel;

    public function __construct()
    {
        $this->dokumenModel = new DokumenModel();
        $this->bidangModel  = new BidangModel();
    }

    /**
     * =================================
     * DAFTAR DOKUMEN MASUK (KAPRODI / KAJUR)
     * =================================
     */
    public function index()
    {
        $role     = session()->get('role');
        $bidangId = session()->get('bidang_id');

        if ($role !== 'atasan' || !$bidangId) {
            return redirect()->back()->with('error', 'Akses tidak diizinkan');
        }

        $bidangUser = $this->bidangModel->find($bidangId);
        if (!$bidangUser) {
            return redirect()->back()->with('error', 'Unit kerja tidak valid');
        }

        // =========================
        // KETUA PRODI
        // =========================
        if ($bidangUser['parent_id'] !== null) {
            $dokumen = $this->dokumenModel
                ->where('status', 'pending_kaprodi')
                ->where('unit_asal_id', $bidangUser['id'])
                ->orderBy('created_at', 'DESC')
                ->findAll();
        }
        // =========================
        // KETUA JURUSAN
        // =========================
        else {
            $dokumen = $this->dokumenModel
                ->where('status', 'pending_kajur')
                ->where('unit_jurusan_id', $bidangUser['id'])
                ->orderBy('created_at', 'DESC')
                ->findAll();
        }
// LOG AKTIVITAS
        log_activity(
    'view_dokumen_masuk',
    'Melihat daftar dokumen masuk untuk direview',
    'dokumen',
    null
);


        return view('atasan/dokumen/index', [
            'dokumen' => $dokumen
        ]);
    }

    /**
     * =================================
     * DETAIL / REVIEW DOKUMEN
     * =================================
     */
    public function review($id)
    {
        $dokumen = $this->dokumenModel->find($id);

        if (!$dokumen) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan');
        }

        if (!$this->canReview($dokumen)) {
            return redirect()->back()->with('error', 'Anda tidak berhak mereview dokumen ini');
        }

        log_activity(
    'review_dokumen',
    "Membuka review dokumen '{$dokumen['judul']}'",
    'dokumen',
    $dokumen['id']
);


        return view('atasan/dokumen/review', [
            'dokumen' => $dokumen
        ]);
    }

    /**
     * =================================
     * APPROVE DOKUMEN
     * =================================
     */
    public function approve($id)
{
    $dokumen = $this->dokumenModel->find($id);

    if (!$dokumen || !$this->canReview($dokumen)) {
        return redirect()->back()->with('error', 'Aksi tidak valid');
    }

    /**
     * =========================
     * KETUA PRODI
     * =========================
     * Pending Kaprodi → Kirim ke Kajur
     */
    if ($dokumen['status'] === 'pending_kaprodi') {

        $this->dokumenModel->update($id, [
            'status'           => 'pending_kajur',
            'current_reviewer' => 'kajur',
            'catatan'          => null,
            'updated_at'       => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * =========================
     * KETUA JURUSAN (FINAL)
     * =========================
     * Pending Kajur → Arsip / Publish
     */
    elseif ($dokumen['status'] === 'pending_kajur') {

        $updateData = [
            'status'           => 'archived',
            'current_reviewer' => null,
            'catatan'          => null,
            'updated_at'       => date('Y-m-d H:i:s'),
        ];

        //  Dokumen public → auto publish
        if ($dokumen['scope'] === 'public') {
            $updateData['published_at'] = date('Y-m-d H:i:s');
        }

        $this->dokumenModel->update($id, $updateData);
    }

    else {
        return redirect()->back()->with('error', 'Status dokumen tidak valid');
    }
// LOG AKTIVITAS
    log_activity(
    'approve_dokumen',
    "Menyetujui dokumen '{$dokumen['judul']}' dari unit {$dokumen['unit_asal_id']} (scope {$dokumen['scope']})",
    'dokumen',
    $dokumen['id']
);


    return redirect()->to('/atasan/dokumen')
        ->with('success', 'Dokumen berhasil disetujui');
}



    /**
     * =================================
     * REJECT DOKUMEN
     * =================================
     */
    public function reject($id)
{
    $dokumen = $this->dokumenModel->find($id);

    if (!$dokumen || !$this->canReview($dokumen)) {
        return redirect()->back()->with('error', 'Aksi tidak valid');
    }

    $catatan = $this->request->getPost('catatan');
    if (!$catatan) {
        return redirect()->back()->with('error', 'Catatan penolakan wajib diisi');
    }

    // Ambil unit atasan
    $bidangId   = session()->get('bidang_id');
    $bidangUser = $this->bidangModel->find($bidangId);

    if (!$bidangUser) {
        return redirect()->back()->with('error', 'Unit tidak valid');
    }

    // =========================
    // KETUA PRODI
    // =========================
    if ($bidangUser['parent_id'] !== null) {

        $this->dokumenModel->update($id, [
            'status'           => 'rejected_kaprodi',
            'current_reviewer' => null,
            'catatan'          => $catatan
        ]);
    }
    // =========================
    // KETUA JURUSAN
    // =========================
    else {

        $this->dokumenModel->update($id, [
            'status'           => 'rejected_kajur',
            'current_reviewer' => null,
            'catatan'          => $catatan
        ]);
    }
    // LOG AKTIVITAS
    log_activity(
    'reject_dokumen',
    "Menolak dokumen '{$dokumen['judul']}' dengan catatan penolakan",
    'dokumen',
    $dokumen['id']
);


    return redirect()->to('/atasan/dokumen')
        ->with('success', 'Dokumen berhasil ditolak');
}


    /**
     * =================================
     * VALIDASI HAK REVIEW
     * =================================
     */
    private function canReview(array $dokumen): bool
{
    // Hanya atasan
    if (session()->get('role') !== 'atasan') {
        return false;
    }

    $bidangId = session()->get('bidang_id');
    if (!$bidangId) {
        return false;
    }

    $bidangUser = $this->bidangModel->find($bidangId);
    if (!$bidangUser) {
        return false;
    }

    /**
     * =========================
     * KETUA PRODI
     * =========================
     * HANYA:
     * - status pending_kaprodi
     * - dokumen dari unit sendiri
     */
    if ($bidangUser['parent_id'] !== null) {
        return $dokumen['status'] === 'pending_kaprodi'
            && $dokumen['unit_asal_id'] == $bidangUser['id'];
    }

    /**
     * =========================
     * KETUA JURUSAN
     * =========================
     */
    if ($dokumen['status'] !== 'pending_kajur') {
        return false;
    }

    /**
     *  DOKUMEN PUBLIC
     * Kajur BOLEH review SEMUA dokumen public
     * di jurusannya (lintas prodi)
     */
    if ($dokumen['scope'] === 'public') {
        return $dokumen['unit_jurusan_id'] == $bidangUser['id'];
    }

    /**
     *  DOKUMEN NON-PUBLIC (unit / personal)
     * Tetap ketat
     */
    return $dokumen['unit_jurusan_id'] == $bidangUser['id'];
}


    /**
     * =================================
     * ARSIP DOKUMEN (HANYA KAJUR)
     * =================================
     */
    public function arsip()
{
    if (session()->get('role') !== 'atasan') {
        return redirect()->back();
    }

    $bidangId = session()->get('bidang_id');
    $bidang   = $this->bidangModel->find($bidangId);

    if (!$bidang) {
        return redirect()->back();
    }

    // ============================
    // KETUA JURUSAN (FULL ARSIP)
    // ============================
    if ($bidang['parent_id'] === null) {

        $data['dokumen'] = $this->dokumenModel
            ->where('status', 'archived')
            ->where('unit_jurusan_id', $bidangId)
            ->orderBy('updated_at', 'DESC')
            ->findAll();
    }

    // ============================
    // KETUA PRODI (READ ONLY)
    // ============================
    else {

        $data['dokumen'] = $this->dokumenModel
            ->where('status', 'archived')
            ->where('unit_jurusan_id', $bidang['parent_id']) // 🔥 KUNCI
            ->where('unit_asal_id', $bidangId)
            ->orderBy('updated_at', 'DESC')
            ->findAll();
    }
// LOG AKTIVITAS
    log_activity(
    'view_dokumen_arsip',
    'Melihat arsip dokumen kinerja',
    'dokumen',
    null
);


    return view('atasan/dokumen/arsip', $data);
}


/**
 * =================================
 * DOKUMEN UNIT (READ ONLY)
 * =================================
 */
public function unit()
{
    if (session()->get('role') !== 'atasan') {
        return redirect()->back();
    }

    $bidangId = session()->get('bidang_id');
    if (!$bidangId) {
        return redirect()->back();
    }

    $dokumen = $this->dokumenModel->getDokumenUnit($bidangId);
// LOG AKTIVITAS
    log_activity(
    'view_dokumen_unit',
    'Melihat dokumen unit (read-only)',
    'dokumen',
    null
);

    return view('atasan/dokumen/unit', [
        'dokumen' => $dokumen
    ]);
}

//
public function public()
{
    if (session()->get('role') !== 'atasan') {
        return redirect()->back()->with('error', 'Akses tidak diizinkan');
    }

    $data['dokumen'] = $this->dokumenModel->getDokumenPublic();
// LOG AKTIVITAS
    log_activity(
    'view_dokumen_public',
    'Melihat dokumen publik',
    'dokumen',
    null
);

    return view('atasan/dokumen/public', $data);
}


}
