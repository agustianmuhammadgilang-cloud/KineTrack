<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SasaranModel;
use App\Models\TahunAnggaranModel;
use App\Models\NotificationModel;
use App\Models\UserModel;

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
            ->join('tahun_anggaran', 'tahun_anggaran.id = sasaran_strategis.tahun_id')
            ->orderBy('tahun_anggaran.tahun', 'DESC')
            ->findAll();

        return view('admin/sasaran/index', $data);
    }

    public function create()
    {
        $data['tahun'] = $this->tahun->where('status', 'active')->findAll();
        return view('admin/sasaran/create', $data);
    }

    public function store()
    {
        $kode = $this->request->getPost('kode_sasaran');
        $nama = $this->request->getPost('nama_sasaran');
        $tahunId = $this->request->getPost('tahun_id');

        $this->model->insert([
            'tahun_id'     => $tahunId,
            'kode_sasaran' => $kode,
            'nama_sasaran' => $nama,
        ]);

        // ======= NOTIFIKASI STAFF =======
        $notificationModel = new NotificationModel();
        $staffUsers = (new UserModel())->where('role','staff')->findAll();
        foreach ($staffUsers as $staff) {
            $notificationModel->insert([
                'user_id' => $staff['id'],
                'title'   => 'Sasaran Strategis Ditambahkan',
                'message' => "Admin menambahkan Sasaran Strategis: $nama",
                'type'    => 'success',
                'is_read' => 0
            ]);
        }

        return redirect()->to('/admin/sasaran')
            ->with('success', 'Sasaran Strategis berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['sasaran'] = $this->model->find($id);
        $data['tahun'] = $this->tahun->findAll();
        return view('admin/sasaran/edit', $data);
    }

    public function update($id)
    {
        $kode = $this->request->getPost('kode_sasaran');
        $nama = $this->request->getPost('nama_sasaran');
        $triwulan = $this->request->getPost('triwulan');
        $tahunId = $this->request->getPost('tahun_id');

        $this->model->update($id, [
            'tahun_id'     => $tahunId,
            'kode_sasaran' => $kode,
            'nama_sasaran' => $nama,
            'triwulan'     => $triwulan,
        ]);

        return redirect()->to('/admin/sasaran')
            ->with('success', 'Sasaran Strategis berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/sasaran')
            ->with('success', 'Sasaran Strategis berhasil dihapus');
    }
}
