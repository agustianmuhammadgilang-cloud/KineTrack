<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TahunAnggaranModel;

class TahunAnggaran extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new TahunAnggaranModel();
    }

    public function index()
    {
        $data['tahun'] = $this->model->orderBy('tahun', 'DESC')->findAll();
        return view('admin/tahun/index', $data);
    }

    public function create()
    {
        return view('admin/tahun/create');
    }

    public function store()
    {
        $this->model->insert([
            'tahun'  => $this->request->getPost('tahun'),
            'status' => $this->request->getPost('status')
        ]);

        return redirect()->to('/admin/tahun')->with('success', 'Tahun berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['tahun'] = $this->model->find($id);
        return view('admin/tahun/edit', $data);
    }

    public function update($id)
    {
        $this->model->update($id, [
            'tahun'  => $this->request->getPost('tahun'),
            'status' => $this->request->getPost('status'),
        ]);

        return redirect()->to('/admin/tahun')->with('success', 'Tahun berhasil diupdate');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/tahun')->with('success', 'Tahun berhasil dihapus');
    }
}