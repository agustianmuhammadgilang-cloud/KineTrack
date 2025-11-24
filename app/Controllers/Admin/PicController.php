<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PicModel;
use App\Models\TahunAnggaranModel;
use App\Models\SasaranModel;
use App\Models\IndikatorModel;
use App\Models\UserModel;
use App\Models\NotificationModel;

class PicController extends BaseController
{
    protected $picModel;
    protected $userModel;
    protected $notifModel;

    public function __construct()
    {
        $this->picModel = new PicModel();
        $this->userModel = new UserModel();
        $this->notifModel = new NotificationModel();
    }

    public function index()
    {
        $data['pic_list'] = $this->picModel
            ->select('pic_indikator.*, users.nama, jabatan.nama_jabatan, bidang.nama_bidang, indikator_kinerja.nama_indikator')
            ->join('users', 'users.id = pic_indikator.user_id')
            ->join('jabatan', 'jabatan.id = users.jabatan_id', 'left')
            ->join('bidang', 'bidang.id = users.bidang_id', 'left')
            ->join('indikator_kinerja', 'indikator_kinerja.id = pic_indikator.indikator_id')
            ->findAll();

        return view('admin/pic/index', $data);
    }

    public function create()
    {
        $data['tahun'] = (new TahunAnggaranModel())
                    ->where('status', 'active')
                    ->findAll();

        return view('admin/pic/create', $data);
    }

    public function store()
    {
        $indikatorId = $this->request->getPost('indikator_id');
        $tahunId     = $this->request->getPost('tahun_id');
        $sasaranId   = $this->request->getPost('sasaran_id');
        $userList    = $this->request->getPost('pegawai'); // array pegawai staff

        foreach ($userList as $userId) {

            $user = $this->userModel->find($userId);

            // simpan data PIC
            $this->picModel->insert([
                'indikator_id' => $indikatorId,
                'user_id'      => $userId,
                'tahun_id'     => $tahunId,
                'sasaran_id'   => $sasaranId,
                'bidang_id'    => $user['bidang_id'],
                'jabatan_id'   => $user['jabatan_id']
            ]);

            // ===========================
            // NOTIFIKASI UNTUK STAFF
            // ===========================
            $this->notifModel->insert([
                'user_id' => $userId,
                'message' => 'Anda telah ditugaskan sebagai PIC baru. Silakan cek Task Anda.',
            ]);
        }

        // ===========================
        // NOTIFIKASI UNTUK ADMIN
        // ===========================
        return redirect()->to('/admin/pic')
            ->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'message' => 'PIC disimpan.'
            ]);
    }

    // ====================== AJAX ======================

    public function getSasaran()
    {
        $tahunId = $this->request->getGet('tahun_id');
        $sasaran = (new SasaranModel())
            ->where('tahun_id', $tahunId)
            ->findAll();

        return $this->response->setJSON($sasaran);
    }

    public function getIndikator()
    {
        $sasaranId = $this->request->getGet('sasaran_id');
        $indikator = (new IndikatorModel())
            ->where('sasaran_id', $sasaranId)
            ->findAll();

        return $this->response->setJSON($indikator);
    }

    public function getPegawai()
    {
        return $this->response->setJSON(
            $this->userModel
                ->select('users.*, jabatan.nama_jabatan, bidang.nama_bidang')
                ->join('jabatan', 'jabatan.id = users.jabatan_id', 'left')
                ->join('bidang', 'bidang.id = users.bidang_id', 'left')
                ->where('users.role !=', 'admin') // hanya staff dan atasan
                ->findAll()
        );
    }
}