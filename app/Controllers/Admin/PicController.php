<?php

// 3️⃣ Controller: app/Controllers/Admin/PicController.php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PicModel;
use App\Models\TahunAnggaranModel;
use App\Models\SasaranModel;
use App\Models\IndikatorModel;
use App\Models\BidangModel;
use App\Models\JabatanModel;
use App\Models\UserModel;

class PicController extends BaseController
{
    protected $picModel;

    public function __construct()
    {
        $this->picModel = new PicModel();
    }

    public function index()
    {
        $data['pic_list'] = $this->picModel->findAll();
        return view('admin/pic/index', $data);
    }

    public function create()
    {
        $data['tahun'] = (new TahunAnggaranModel())->findAll();
        $data['bidang'] = (new BidangModel())->findAll();
        return view('admin/pic/create', $data);
    }

    public function store()
    {
        $indikatorId = $this->request->getPost('indikator_id');
        $tahunId = $this->request->getPost('tahun_id');
        $sasaranId = $this->request->getPost('sasaran_id');
        $bidangList = $this->request->getPost('bidang');
        $jabatanList = $this->request->getPost('jabatan');
        $pegawaiList = $this->request->getPost('pegawai');

        foreach ($pegawaiList as $i => $userId) {
            $this->picModel->insert([
                'indikator_id' => $indikatorId,
                'user_id' => $userId,
                'tahun_id' => $tahunId,
                'sasaran_id' => $sasaranId,
                'bidang_id' => $bidangList[$i],
                'jabatan_id' => $jabatanList[$i],
            ]);
        }

        return redirect()->to('/admin/pic')->with('success','PIC berhasil ditambahkan');
    }

    // AJAX endpoints
    public function getSasaran()
    {
        $tahunId = $this->request->getGet('tahun_id');
        $sasaran = (new SasaranModel())->where('tahun_id',$tahunId)->findAll();
        return $this->response->setJSON($sasaran);
    }

    public function getIndikator()
    {
        $sasaranId = $this->request->getGet('sasaran_id');
        $indikator = (new IndikatorModel())->where('sasaran_id',$sasaranId)->findAll();
        return $this->response->setJSON($indikator);
    }

    public function getJabatan()
    {
        $bidangId = $this->request->getGet('bidang_id');
        $jabatan = (new JabatanModel())->where('bidang_id',$bidangId)->findAll();
        return $this->response->setJSON($jabatan);
    }

    public function getPegawai()
    {
        $jabatanId = $this->request->getGet('jabatan_id');
        $pegawai = (new UserModel())->where('jabatan_id',$jabatanId)->findAll();
        return $this->response->setJSON($pegawai);
    }
}
