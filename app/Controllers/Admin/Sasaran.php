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

    public function index()
    {
        $data['sasaran'] = $this->model
            ->select('sasaran_strategis.*, tahun_anggaran.tahun')
            ->join('tahun_anggaran','tahun_anggaran.id=sasaran_strategis.tahun_id')
            ->orderBy('tahun_anggaran.tahun','DESC')
            ->findAll();

        return view('admin/sasaran/index', $data);
    }

    public function create()
    {
        $data['tahun'] = $this->tahun->findAll();
        return view('admin/sasaran/create', $data);
    }

    public function store()
    {
        $this->model->insert([
            'tahun_id' => $this->request->getPost('tahun_id'),
            'kode_sasaran' => $this->request->getPost('kode_sasaran'),
            'nama_sasaran' => $this->request->getPost('nama_sasaran'),
        ]);

        $data = [
            'tahun_id'      => $this->request->getPost('tahun_id'),
            'kode_sasaran'  => $this->request->getPost('kode_sasaran'),
            'nama_sasaran'  => $this->request->getPost('nama_sasaran'),
            'triwulan'      => $this->request->getPost('triwulan'),
        ];

        $model->insert($data);



        return redirect()->to('/admin/sasaran')->with('success', 'Sasaran ditambahkan');
    }

    public function edit($id)
    {
        $data['sasaran'] = $this->model->find($id);
        $data['tahun'] = $this->tahun->findAll();
        return view('admin/sasaran/edit', $data);
    }

    public function update($id)
    {
        $this->model->update($id, [
            'tahun_id' => $this->request->getPost('tahun_id'),
            'kode_sasaran' => $this->request->getPost('kode_sasaran'),
            'nama_sasaran' => $this->request->getPost('nama_sasaran'),
        ]);
        return redirect()->to('/admin/sasaran')->with('success','Diupdate');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/sasaran')->with('success','Dihapus');
    }
}
