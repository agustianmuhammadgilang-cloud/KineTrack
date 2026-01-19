<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SasaranModel;
use App\Models\TahunAnggaranModel;
// Controller untuk mengelola sasaran strategis
class Sasaran extends BaseController
{
    protected $model;
    protected $tahun;

    public function __construct()
    {
        $this->model = new SasaranModel();
        $this->tahun = new TahunAnggaranModel();
    }

    /* =============================
       INDEX (LIST SASARAN)
    ============================== */
public function index()
{
    $data['sasaran'] = $this->model
        ->select('sasaran_strategis.*, tahun_anggaran.tahun')
        ->join(
            'tahun_anggaran',
            'tahun_anggaran.id = sasaran_strategis.tahun_id'
        )
        ->where('tahun_anggaran.status', 'active') // 🔥 FILTER TAHUN AKTIF
        ->orderBy('tahun_anggaran.tahun', 'DESC')
        ->findAll();

    return view('admin/sasaran/index', $data);
}


    /* =============================
       CREATE FORM
    ============================== */
    public function create()
    {
        $data['tahun'] = $this->tahun->where('status', 'active')->findAll();
        return view('admin/sasaran/create', $data);
    }

    /* =============================
       STORE DATA SASARAN
    ============================== */
    public function store()
{
    $tahunId     = $this->request->getPost('tahun_id');
    $kodeSasaran = $this->request->getPost('kode_sasaran');
    $namaSasaran = trim($this->request->getPost('nama_sasaran'));

    // =============================
    // VALIDASI DUPLIKASI (TAMBAHAN)
    // =============================
    $cek = $this->model
        ->where('tahun_id', $tahunId)
        ->where('nama_sasaran', $namaSasaran)
        ->first();

    if ($cek) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Sasaran strategis ini sudah tersedia');
    }
    // =============================
    // LOGIKA LAMA (TIDAK DIUBAH)
    // =============================

    $data = [
        'tahun_id'     => $tahunId,
        'kode_sasaran' => $kodeSasaran,
        'nama_sasaran' => $namaSasaran,
    ];

    $sasaranId = $this->model->insert($data);

// LOG AKTIVITAS ADMIN
log_activity(
    'create_sasaran',
    'Menambahkan sasaran strategis: ' . $namaSasaran,
    'sasaran',
    $sasaranId
);

    return redirect()->to('/admin/sasaran')
        ->with('success', 'Sasaran Strategis berhasil ditambahkan');
}



    /* =============================
       EDIT FORM
    ============================== */
    public function edit($id)
    {
        $data['sasaran'] = $this->model->find($id);
        $data['tahun'] = $this->tahun->findAll();

        return view('admin/sasaran/edit', $data);
    }

    /* =============================
       UPDATE DATA SASARAN
    ============================== */
    public function update($id)
{
    $tahunId     = $this->request->getPost('tahun_id');
    $kodeSasaran = $this->request->getPost('kode_sasaran');
    $namaSasaran = trim($this->request->getPost('nama_sasaran'));

    // =============================
    // VALIDASI DUPLIKASI (TAMBAHAN)
    // =============================
    $cek = $this->model
        ->where('tahun_id', $tahunId)
        ->where('nama_sasaran', $namaSasaran)
        ->where('id !=', $id) // abaikan data yang sedang diedit
        ->first();

    if ($cek) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Sasaran strategis ini sudah tersedia, harap gunakan nama lain');
    }
    // =============================
    // LOGIKA LAMA (TIDAK DIUBAH)
    // =============================

    $data = [
        'tahun_id'     => $tahunId,
        'kode_sasaran' => $kodeSasaran,
        'nama_sasaran' => $namaSasaran,
        'triwulan'     => $this->request->getPost('triwulan'),
    ];

    $this->model->update($id, $data);
    // LOG AKTIVITAS ADMIN
log_activity(
    'update_sasaran',
    'Mengubah sasaran strategis: ' . $namaSasaran,
    'sasaran',
    $id
);

    return redirect()->to('/admin/sasaran')
        ->with('success', 'Sasaran Strategis berhasil diperbarui');
}


    /* =============================
       DELETE
    ============================== */
    public function delete($id)
    {
        $this->model->delete($id);
        $sasaran = $this->model->find($id); // ambil dulu untuk deskripsi

$this->model->delete($id);

//  LOG AKTIVITAS ADMIN
log_activity(
    'delete_sasaran',
    'Menghapus sasaran strategis: ' . ($sasaran['nama_sasaran'] ?? ''),
    'sasaran',
    $id
);
        return redirect()->to('/admin/sasaran')
            ->with('success', 'Sasaran Strategis berhasil dihapus');
    }
// Mendapatkan daftar triwulan berdasarkan tahun yang dipilih
    public function getTriwulan()
{
    $tahunId = $this->request->getGet('tahun_id');

    $triwulanList = $this->model
        ->select('DISTINCT triwulan')
        ->where('tahun_id', $tahunId)
        ->findAll();

    $result = array_map(fn($r) => (int)$r['triwulan'], $triwulanList);

    return $this->response->setJSON($result);
}
public function getKode($tahunId)
{
    $model = new SasaranModel();

    $last = $model->where('tahun_id', $tahunId)
                  ->orderBy('id', 'DESC')
                  ->first();

    if (!$last) {
        return $this->response->setJSON(['kode' => "SS-01"]);
    }

    $lastNumber = (int)substr($last['kode_sasaran'], -2);
    $newNumber  = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);

    return $this->response->setJSON([
        'kode' => "SS-{$newNumber}"
    ]);
}

// Mendapatkan kode sasaran baru berdasarkan tahun yang dipilih

}