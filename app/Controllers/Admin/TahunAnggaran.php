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
        $tahun  = $this->request->getPost('tahun');
        $status = $this->request->getPost('status');

        // Cek duplikasi
        if ($this->model->where('tahun', $tahun)->first()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Tahun sudah ada!');
        }

        // 🔥 JIKA AKTIF → NONAKTIFKAN YANG LAIN
        if ($status === 'active') {
            $this->model
                ->where('status', 'active')
                ->set(['status' => 'inactive'])
                ->update();
        }

        $tahunId = $this->model->insert([
            'tahun'  => $tahun,
            'status' => $status
        ]);

        log_activity(
            'create_tahun',
            'Menambahkan tahun anggaran ' . $tahun .
            ($status === 'active' ? ' dan mengaktifkannya' : ''),
            'tahun_anggaran',
            $tahunId
        );

        return redirect()->to('/admin/tahun')
            ->with('success', 'Tahun berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['tahun'] = $this->model->find($id);
        return view('admin/tahun/edit', $data);
    }

    public function update($id)
    {
        $tahun  = $this->request->getPost('tahun');
        $status = $this->request->getPost('status');

        $existing = $this->model
            ->where('tahun', $tahun)
            ->where('id !=', $id)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Tahun sudah tersedia!');
        }

        // 🔥 JIKA DIAKTIFKAN → NONAKTIFKAN YANG LAIN
        if ($status === 'active') {
            $this->model
                ->where('id !=', $id)
                ->set(['status' => 'inactive'])
                ->update();
        }

        $this->model->update($id, [
            'tahun'  => $tahun,
            'status' => $status,
        ]);

        log_activity(
            'update_tahun_status',
            ($status === 'active'
                ? 'Mengaktifkan'
                : 'Menonaktifkan') . ' tahun anggaran ' . $tahun,
            'tahun_anggaran',
            $id
        );

        return redirect()->to('/admin/tahun')
            ->with('success', 'Status tahun anggaran berhasil diperbarui');
    }

    public function delete($id)
    {
        $tahun = $this->model->find($id);

        if ($tahun['status'] === 'active') {
            return redirect()->back()
                ->with('error', 'Tahun aktif tidak boleh dihapus.');
        }

        $this->model->delete($id);

        log_activity(
            'delete_tahun',
            'Menghapus tahun anggaran ' . $tahun['tahun'],
            'tahun_anggaran',
            $id
        );

        return redirect()->to('/admin/tahun')
            ->with('success', 'Tahun berhasil dihapus');
    }
}
