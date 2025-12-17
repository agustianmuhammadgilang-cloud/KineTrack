<?php

namespace App\Controllers\Atasan;

use App\Controllers\BaseController;
use App\Models\DokumenModel;
use App\Models\BidangModel;

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

        // Ketua Prodi → ke Kajur
        if ($dokumen['status'] === 'pending_kaprodi') {
            $this->dokumenModel->update($id, [
                'status'           => 'pending_kajur',
                'current_reviewer' => 'kajur',
                'catatan'          => null
            ]);
        }
        // Ketua Jurusan → arsip
        elseif ($dokumen['status'] === 'pending_kajur') {
            $this->dokumenModel->update($id, [
                'status'           => 'archived',
                'current_reviewer' => null,
                'catatan'          => null
            ]);
        } else {
            return redirect()->back()->with('error', 'Status dokumen tidak valid');
        }

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

        // Ketua Prodi
        if ($bidangUser['parent_id'] !== null) {
            return $dokumen['status'] === 'pending_kaprodi'
                && $dokumen['unit_asal_id'] == $bidangUser['id'];
        }

        // Ketua Jurusan
        return $dokumen['status'] === 'pending_kajur'
            && $dokumen['unit_jurusan_id'] == $bidangUser['id'];
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

    return view('atasan/dokumen/arsip', $data);
}

}
