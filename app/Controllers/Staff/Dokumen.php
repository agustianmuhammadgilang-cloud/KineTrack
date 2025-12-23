<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\DokumenModel;
use App\Models\BidangModel;
use App\Models\KategoriDokumenModel;

class Dokumen extends BaseController
{
    protected $dokumenModel;
    protected $bidangModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->dokumenModel  = new DokumenModel();
        $this->bidangModel   = new BidangModel();
        $this->kategoriModel = new KategoriDokumenModel();
    }

    /**
     * ============================
     * LIST DOKUMEN MILIK STAFF
     * ============================
     */
    public function index()
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        $data['dokumen'] = $this->dokumenModel
            ->where('created_by', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('staff/dokumen/index', $data);
    }

    /**
     * ============================
     * FORM UPLOAD DOKUMEN
     * ============================
     */
public function create()
{
    return view('staff/dokumen/create', [
        'kategori' => $this->kategoriModel->getUntukFormStaff()
    ]);
}



    /**
     * ============================
     * SIMPAN DOKUMEN
     * ============================
     */
    public function store()
{
    $userId     = session()->get('user_id');
    $bidangId   = session()->get('bidang_id');
    $kategoriId = $this->request->getPost('kategori_id');

    if (!$userId || !$bidangId) {
        return redirect()->to('/login');
    }

    // 🔴 WAJIB
    if (!$kategoriId) {
        return redirect()->back()->with('error', 'Kategori wajib dipilih');
    }

    $file = $this->request->getFile('file');
    if (!$file || !$file->isValid()) {
        return redirect()->back()->with('error', 'File tidak valid');
    }

    $bidangUser = $this->bidangModel->find($bidangId);

    if ($bidangUser['parent_id'] !== null) {
        $unitAsal    = $bidangUser['id'];
        $unitJurusan = $bidangUser['parent_id'];
        $status      = 'pending_kaprodi';
        $reviewer    = 'kaprodi';
    } else {
        $unitAsal    = $bidangUser['id'];
        $unitJurusan = $bidangUser['id'];
        $status      = 'pending_kajur';
        $reviewer    = 'kajur';
    }

    $newName = $file->getRandomName();
    $file->move('uploads/dokumen', $newName);
    $scopeInput = $this->request->getPost('scope');

    $scope = in_array($scopeInput, ['personal', 'unit', 'public'])
    ? $scopeInput
    : 'unit';



    // ✅ kategori_id DISIMPAN
    $this->dokumenModel->insert([
        'judul'            => $this->request->getPost('judul'),
        'deskripsi'        => $this->request->getPost('deskripsi'),
        'kategori_id'      => $kategoriId, // ⬅️ INI KUNCI
        'scope'            => $scope,
        'file_path'        => $newName,
        'created_by'       => $userId,
        'unit_asal_id'     => $unitAsal,
        'unit_jurusan_id'  => $unitJurusan,
        'status'           => $status,
        'current_reviewer' => $reviewer,
    ]);

    return redirect()->to('/staff/dokumen')
        ->with('success', 'Dokumen berhasil dikirim');
}


    /**
     * ============================
     * FORM REVISI DOKUMEN
     * ============================
     */
    public function resubmit($id)
    {
        $userId = session()->get('user_id');

        $dokumen = $this->dokumenModel
            ->where('id', $id)
            ->where('created_by', $userId)
            ->whereIn('status', ['rejected_kaprodi', 'rejected_kajur'])
            ->first();

        if (!$dokumen) {
            return redirect()->back()->with('error', 'Dokumen tidak dapat direvisi');
        }

        return view('staff/dokumen/resubmit', [
            'dokumen'  => $dokumen,
            'kategori' => $this->kategoriModel->getAktif()
        ]);
    }

    /**
     * ============================
     * PROSES REVISI
     * ============================
     */
    public function processResubmit($id)
    {
        $userId   = session()->get('user_id');
        $bidangId = session()->get('bidang_id');

        $dokumen = $this->dokumenModel
            ->where('id', $id)
            ->where('created_by', $userId)
            ->first();

        if (!$dokumen) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan');
        }

        $file = $this->request->getFile('file');
        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid');
        }

        $bidangUser = $this->bidangModel->find($bidangId);

        // Tentukan ulang alur (TIDAK DIUBAH)
        if ($bidangUser['parent_id'] !== null) {
            $status   = 'pending_kaprodi';
            $reviewer = 'kaprodi';
        } else {
            $status   = 'pending_kajur';
            $reviewer = 'kajur';
        }

        // Upload file baru
        $newName = $file->getRandomName();
        $file->move('uploads/dokumen', $newName);

        $this->dokumenModel->update($id, [
            'judul'            => $this->request->getPost('judul'),
            'deskripsi'        => $this->request->getPost('deskripsi'),
            'kategori_id'      => $this->request->getPost('kategori_id'),
            'file_path'        => $newName,
            'status'           => $status,
            'current_reviewer' => $reviewer,
            'catatan'          => null,
            'updated_at'       => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/staff/dokumen')
            ->with('success', 'Dokumen berhasil dikirim ulang');
    }

    /**
     * ============================
     * ARSIP
     * ============================
     */
    public function arsip()
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        $data['dokumen'] = $this->dokumenModel
            ->where('created_by', $userId)
            ->where('status', 'archived')
            ->orderBy('updated_at', 'DESC')
            ->findAll();

        return view('staff/dokumen/arsip', $data);
    }
    /**
 * ============================
 * DOKUMEN PERSONAL (DOKUMEN SAYA)
 * ============================
 */
public function personal()
{
    $userId = session()->get('user_id');

    if (!$userId) {
        return redirect()->to('/login');
    }

    $data['dokumen'] = $this->dokumenModel
        ->where('created_by', $userId)
        ->where('scope', 'personal') // asumsi dari pilihan saat create
        ->orderBy('created_at', 'DESC')
        ->findAll();

    return view('staff/dokumen/personal', $data);
}

/**
 * ============================
 * DOKUMEN UNIT
 * ============================
 */
public function unit()
{
    $userId   = session()->get('user_id');
    $bidangId = session()->get('bidang_id');

    if (!$userId || !$bidangId) {
        return redirect()->to('/login');
    }

    $bidangUser = $this->bidangModel->find($bidangId);

    // Tentukan unit jurusan
    $unitJurusan = $bidangUser['parent_id'] ?? $bidangUser['id'];

    $data['dokumen'] = $this->dokumenModel
        ->where('unit_jurusan_id', $unitJurusan)
        ->where('scope', 'unit')
        ->orderBy('created_at', 'DESC')
        ->findAll();

    return view('staff/dokumen/unit', $data);
}

public function public()
{
    if (!session()->get('user_id')) {
        return redirect()->to('/login');
    }

    $table = $this->dokumenModel->getTable(); // dokumen_kinerja

    $data['dokumen'] = $this->dokumenModel
        ->select("
            {$table}.*,
            bidang.nama_bidang AS nama_unit,
            kategori_dokumen.nama_kategori
        ")
        ->join('bidang', "bidang.id = {$table}.unit_jurusan_id", 'left')
        ->join('kategori_dokumen', "kategori_dokumen.id = {$table}.kategori_id", 'left')
        ->where("{$table}.scope", 'public')
        ->where("{$table}.status", 'archived')
        ->orderBy("{$table}.created_at", 'DESC')
        ->findAll();

    return view('staff/dokumen/public', $data);
}


}
