<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\IndikatorModel;
use App\Models\SasaranModel;
use App\Models\TahunAnggaranModel;
// Controller untuk mengelola indikator kinerja
class Indikator extends BaseController
{
    protected $model;
    protected $sasaran;
    protected $tahun;

    public function __construct()
    {
        $this->model   = new IndikatorModel();
        $this->sasaran = new SasaranModel();
        $this->tahun   = new TahunAnggaranModel();
    }
// Menampilkan daftar indikator
    public function index()
    {
$data['indikator'] = $this->model
    ->select('
        indikator_kinerja.*,
        sasaran_strategis.kode_sasaran,
        sasaran_strategis.nama_sasaran,
        tahun_anggaran.tahun
    ')
    ->join(
        'sasaran_strategis',
        'sasaran_strategis.id = indikator_kinerja.sasaran_id'
    )
    ->join(
        'tahun_anggaran',
        'tahun_anggaran.id = sasaran_strategis.tahun_id'
    )
    ->where('tahun_anggaran.status', 'active') // 🔥 FILTER UTAMA
    ->orderBy('indikator_kinerja.id', 'ASC')
    ->findAll();


        return view('admin/indikator/index', $data);
    }
// Menampilkan form untuk membuat indikator baru
    public function create()
{
    // Ambil semua data sasaran
    $data['sasaran'] = $this->sasaran
        ->select('sasaran_strategis.*, tahun_anggaran.tahun')
        ->join('tahun_anggaran', 'tahun_anggaran.id = sasaran_strategis.tahun_id')
        ->where('tahun_anggaran.status', 'active')
        ->findAll();


    // ====== AUTO-GENERATE KODE INDIKATOR ======

    // Ambil kode indikator terakhir
    $last = $this->model
        ->select('kode_indikator')
        ->orderBy('id', 'DESC')
        ->first();

    if ($last) {
        // Ambil angka dari IK-XX
        $num = intval(substr($last['kode_indikator'], 3));
        $nextNum = $num + 1;
    } else {
        $nextNum = 1;
    }

    // Format IK-01, IK-02, IK-03 ...
    $data['nextKode'] = 'IK-' . str_pad($nextNum, 2, '0', STR_PAD_LEFT);

    return view('admin/indikator/create', $data);
}


// Menyimpan indikator baru
    public function store()
{
    $sasaranId = $this->request->getPost('sasaran_id');
    $nama      = trim($this->request->getPost('nama_indikator'));

    // ===== VALIDASI DUPLIKASI NAMA INDIKATOR =====
    $exists = $this->model
        ->where('sasaran_id', $sasaranId)
        ->where('nama_indikator', $nama)
        ->first();

    if ($exists) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Nama indikator sudah ada pada sasaran dan tahun yang sama');
    }

    // ===== INSERT DATA (LOGIKA LAMA TETAP) =====
    $this->model->insert([
        'sasaran_id'     => $sasaranId,
        'kode_indikator' => $this->request->getPost('kode_indikator'),
        'nama_indikator' => $nama,
        'satuan'         => $this->request->getPost('satuan'),
        'target_pk'      => $this->request->getPost('target_pk'),
        'target_tw1'     => $this->request->getPost('target_tw1'),
        'target_tw2'     => $this->request->getPost('target_tw2'),
        'target_tw3'     => $this->request->getPost('target_tw3'),
        'target_tw4'     => $this->request->getPost('target_tw4'),
        'mode'           => $this->request->getPost('mode'),
    ]);
    $indikatorId = $this->model->getInsertID();
//logaktivitaus create
log_activity(
    'create_indikator',
    'Menambahkan indikator: ' . $nama,
    'indikator_kinerja',
    $indikatorId
);

    return redirect()->to('/admin/indikator')
        ->with('success','Indikator berhasil ditambahkan');
}

// Menampilkan form untuk mengedit indikator
    public function edit($id)
    {
        $data['indikator'] = $this->model->find($id);
        $data['sasaran']   = $this->sasaran->select('sasaran_strategis.*, tahun_anggaran.tahun')
                                           ->join('tahun_anggaran','tahun_anggaran.id=sasaran_strategis.tahun_id')
                                           ->findAll();
        return view('admin/indikator/edit', $data);
    }
// Memperbarui indikator
    public function update($id)
{
    $sasaranId = $this->request->getPost('sasaran_id');
    $nama      = trim($this->request->getPost('nama_indikator'));

    // ===== VALIDASI DUPLIKASI (EXCLUDE ID SENDIRI) =====
    $exists = $this->model
        ->where('sasaran_id', $sasaranId)
        ->where('nama_indikator', $nama)
        ->where('id !=', $id)
        ->first();

    if ($exists) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Nama indikator sudah ada pada sasaran dan tahun yang sama');
    }

    // ===== UPDATE DATA (LOGIKA LAMA TETAP) =====
    $this->model->update($id, [
        'sasaran_id'     => $sasaranId,
        'kode_indikator' => $this->request->getPost('kode_indikator'),
        'nama_indikator' => $nama,
        'satuan'         => $this->request->getPost('satuan'),
        'target_pk'      => $this->request->getPost('target_pk'),
        'target_tw1'     => $this->request->getPost('target_tw1'),
        'target_tw2'     => $this->request->getPost('target_tw2'),
        'target_tw3'     => $this->request->getPost('target_tw3'),
        'target_tw4'     => $this->request->getPost('target_tw4'),
    ]);
    //logaktivitaus update
    log_activity(
    'update_indikator',
    'Memperbarui indikator: ' . $nama,
    'indikator_kinerja',
    $id
);

    return redirect()->to('/admin/indikator')
        ->with('success','Indikator berhasil diperbarui');
}

// Menghapus indikator
    public function delete($id)
    {
        $indikator = $this->model->find($id);
$this->model->delete($id);
//logaktivitaus delete
log_activity(
    'delete_indikator',
    'Menghapus indikator: ' . ($indikator['nama_indikator'] ?? '-'),
    'indikator_kinerja',
    $id
);

return redirect()->to('/admin/indikator')
    ->with('success','Dihapus');

    }
// Mendapatkan kode indikator berikutnya berdasarkan sasaran_id
    public function getNextKode()
{
    $sasaranId = $this->request->getGet('sasaran_id');

    // Hitung berapa indikator pada sasaran tersebut
    $last = $this->model
        ->where('sasaran_id', $sasaranId)
        ->orderBy('id', 'DESC')
        ->first();

    if ($last) {
        // Ambil nomor IK-XX
        $num = intval(substr($last['kode_indikator'], 3));
        $nextNum = $num + 1;
    } else {
        $nextNum = 1;
    }

    return $this->response->setJSON([
        'nextKode' => 'IK-' . str_pad($nextNum, 2, '0', STR_PAD_LEFT)
    ]);
}
// Mendapatkan kode indikator berdasarkan sasaran_id (untuk keperluan lain)
    public function getKode($sasaran_id)
{
    $last = $this->model
        ->where('sasaran_id', $sasaran_id)
        ->orderBy('id', 'DESC')
        ->first();

    if ($last) {
        $num = intval(substr($last['kode_indikator'], 3));
        $nextNum = $num + 1;
    } else {
        $nextNum = 1;
    }

    $nextKode = 'IK-' . str_pad($nextNum, 2, '0', STR_PAD_LEFT);

    return $this->response->setJSON(['kode' => $nextKode]);
}

}