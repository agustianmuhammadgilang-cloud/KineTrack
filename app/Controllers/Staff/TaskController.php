<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\PicModel;
use App\Models\IndikatorModel;
use App\Models\SasaranModel;
use App\Models\PengukuranModel;

class TaskController extends BaseController
{
    protected $picModel;
    protected $indikatorModel;
    protected $sasaranModel;
    protected $pengukuranModel;

    public function __construct()
    {
        $this->picModel        = new PicModel();
        $this->indikatorModel  = new IndikatorModel();
        $this->sasaranModel    = new SasaranModel();
        $this->pengukuranModel = new PengukuranModel();
    }

    // index: menampilkan daftar task staff
    public function index()
    {
        $userId = session()->get('user_id');
        $tasks  = $this->picModel->getTasksForUser($userId);

        return view('staff/task/index', ['tasks' => $tasks]);
    }

    // input: form pengukuran per indikator
    public function input($indikator_id)
    {
        $pic       = $this->picModel->getPicByIndikator($indikator_id);
        $indikator = $this->indikatorModel->find($indikator_id);
        $sasaran   = $this->sasaranModel->find($indikator['sasaran_id'] ?? null);

        if (empty($pic)) {
            return redirect()->to('/staff/task')->with('alert', [
                'type'    => 'warning',
                'title'   => 'Tidak ada PIC',
                'message' => 'Indikator ini belum memiliki PIC.'
            ]);
        }

        // Ambil tahun_id dan TW dari PIC pertama
        $tahun_id = $pic[0]['tahun_id'];
        $tw       = $pic[0]['tw'];

        return view('staff/task/input', [
            'indikator_id' => $indikator_id,
            'pic'          => $pic,
            'indikator'    => $indikator,
            'sasaran'      => $sasaran,
            'tw'           => $tw,
            'tahun_id'     => $tahun_id
        ]);
    }

    // store: simpan input pengukuran
    public function store()
    {
        $indikator_id = $this->request->getPost('indikator_id');
        $user_id      = session()->get('user_id');
        $tw           = $this->request->getPost('tw');
        $tahun_id     = $this->request->getPost('tahun_id');

        // Validasi minimal
        if (!$indikator_id || !$user_id || !$tw || !$tahun_id) {
            return redirect()->back()->with('alert', [
                'type'    => 'warning',
                'title'   => 'Gagal',
                'message' => 'Data pengukuran tidak lengkap.'
            ]);
        }

        $data = [
            'indikator_id' => $indikator_id,
            'user_id'      => $user_id,
            'tw'           => $tw,
            'tahun_id'     => $tahun_id,
            'progress'     => $this->request->getPost('progress'),
            'realisasi'    => $this->request->getPost('realisasi'),
            'kendala'      => $this->request->getPost('kendala'),
            'strategi'     => $this->request->getPost('strategi'),
            'file_dukung'  => null
        ];

        // Buat notifikasi ke admin
$notifModel = new \App\Models\NotificationModel();

$notifModel->insert([
    'receiver_id' => 1, // ID ADMIN utama (bisa diganti dinamis)
    'title'       => 'Input Pengukuran Baru',
    'message'     => 'PIC telah mengisi indikator: ' . $indikator['nama_indikator'],
    'is_read'     => 0
]);


        $this->pengukuranModel->insert($data);

        return redirect()->to('/staff/task')->with('alert', [
            'type'    => 'success',
            'title'   => 'Berhasil',
            'message' => 'Pengukuran berhasil disimpan.'
        ]);
    }
}
