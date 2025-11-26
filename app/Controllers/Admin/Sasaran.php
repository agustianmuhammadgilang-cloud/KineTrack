<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SasaranModel;
use App\Models\TahunAnggaranModel;

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
            ->join('tahun_anggaran', 'tahun_anggaran.id = sasaran_strategis.tahun_id')
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
    $data = [
        'tahun_id'     => $this->request->getPost('tahun_id'),
        'kode_sasaran' => $this->request->getPost('kode_sasaran'),
        'nama_sasaran' => $this->request->getPost('nama_sasaran'),
    ];

    $this->model->insert($data);

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
        $data = [
            'tahun_id'     => $this->request->getPost('tahun_id'),
            'kode_sasaran' => $this->request->getPost('kode_sasaran'),
            'nama_sasaran' => $this->request->getPost('nama_sasaran'),
            'triwulan'     => $this->request->getPost('triwulan'),  // NEW FIELD
        ];

        $this->model->update($id, $data);

        return redirect()->to('/admin/sasaran')
            ->with('success', 'Sasaran Strategis berhasil diperbarui');
    }

    /* =============================
       DELETE
    ============================== */
    public function delete($id)
    {
        $this->model->delete($id);

        return redirect()->to('/admin/sasaran')
            ->with('success', 'Sasaran Strategis berhasil dihapus');
    }

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
        return $this->response->setJSON(['kode' => "SS-{$tahunId}-01"]);
    }

    $lastNumber = (int)substr($last['kode_sasaran'], -2);
    $newNumber  = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);

    return $this->response->setJSON([
        'kode' => "SS-{$tahunId}-{$newNumber}"
    ]);
}

}