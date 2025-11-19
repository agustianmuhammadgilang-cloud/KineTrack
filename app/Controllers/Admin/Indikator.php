<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\IndikatorModel;
use App\Models\SasaranModel;
use App\Models\TahunAnggaranModel;

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

    public function index()
    {
        $data['indikator'] = $this->model
            ->select('indikator_kinerja.*, sasaran_strategis.kode_sasaran, sasaran_strategis.nama_sasaran, tahun_anggaran.tahun')
            ->join('sasaran_strategis','sasaran_strategis.id = indikator_kinerja.sasaran_id')
            ->join('tahun_anggaran','tahun_anggaran.id = sasaran_strategis.tahun_id')
            ->orderBy('tahun_anggaran.tahun','DESC')
            ->findAll();

        return view('admin/indikator/index', $data);
    }

    public function create()
    {
        $data['sasaran'] = $this->sasaran
            ->select('sasaran_strategis.*, tahun_anggaran.tahun')
            ->join('tahun_anggaran','tahun_anggaran.id=sasaran_strategis.tahun_id')
            ->findAll();

        return view('admin/indikator/create', $data);
    }

    public function store()
    {
        $this->model->insert([
            'sasaran_id' => $this->request->getPost('sasaran_id'),
            'kode_indikator' => $this->request->getPost('kode_indikator'),
            'nama_indikator' => $this->request->getPost('nama_indikator'),
            'satuan' => $this->request->getPost('satuan'),
            'target_pk' => $this->request->getPost('target_pk'),
            'target_tw1' => $this->request->getPost('target_tw1'),
            'target_tw2' => $this->request->getPost('target_tw2'),
            'target_tw3' => $this->request->getPost('target_tw3'),
            'target_tw4' => $this->request->getPost('target_tw4'),
        ]);
        return redirect()->to('/admin/indikator')->with('success','Indikator ditambahkan');
    }

    public function edit($id)
    {
        $data['indikator'] = $this->model->find($id);
        $data['sasaran']   = $this->sasaran->select('sasaran_strategis.*, tahun_anggaran.tahun')
                                           ->join('tahun_anggaran','tahun_anggaran.id=sasaran_strategis.tahun_id')
                                           ->findAll();
        return view('admin/indikator/edit', $data);
    }

    public function update($id)
    {
        $this->model->update($id, [
            'sasaran_id' => $this->request->getPost('sasaran_id'),
            'kode_indikator' => $this->request->getPost('kode_indikator'),
            'nama_indikator' => $this->request->getPost('nama_indikator'),
            'satuan' => $this->request->getPost('satuan'),
            'target_pk' => $this->request->getPost('target_pk'),
            'target_tw1' => $this->request->getPost('target_tw1'),
            'target_tw2' => $this->request->getPost('target_tw2'),
            'target_tw3' => $this->request->getPost('target_tw3'),
            'target_tw4' => $this->request->getPost('target_tw4'),
        ]);
        return redirect()->to('/admin/indikator')->with('success','Diupdate');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/indikator')->with('success','Dihapus');
    }
}
