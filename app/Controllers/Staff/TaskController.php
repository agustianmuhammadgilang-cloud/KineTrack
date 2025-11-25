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
        $data['pending_count'] = $this->pending_count;

        $userId = session()->get('user_id');
        $tasks  = $this->picModel->getTasksForUser($userId);

        return view('staff/task/index', ['tasks' => $tasks]);
    }

    // input: form pengukuran per indikator
    public function input($indikator_id)
{
    // Ambil semua PIC terkait indikator
    $pic = $this->picModel->getPicByIndikator($indikator_id);

    // Ambil detail indikator + sasaran
    $indikator = $this->indikatorModel->find($indikator_id);
    $sasaran   = $this->sasaranModel->find($indikator['sasaran_id'] ?? null);

    // Validasi PIC dan indikator
    if (empty($pic) || !$indikator) {
        return redirect()->to('/staff/task')->with('alert', [
            'type'    => 'warning',
            'title'   => 'Tidak dapat mengisi',
            'message' => empty($pic) ? 'Indikator ini belum memiliki PIC.' : 'Indikator tidak ditemukan.'
        ]);
    }

    // Ambil tahun_id dan TW dari PIC pertama
    $tahun_id = $pic[0]['tahun_id'];
    $tw       = $pic[0]['tw'];

    // Pastikan TW valid (1-4)
    if (!in_array($tw, [1, 2, 3, 4])) {
        $tw = 1; // fallback default TW
    }

    return view('staff/task/input', [
        'indikator_id' => $indikator_id,
        'pic'          => $pic,
        'indikator'    => $indikator,
        'sasaran'      => $sasaran,
        'tw'           => $tw,         // ini akan dipakai sebagai triwulan saat simpan
        'tahun_id'     => $tahun_id
    ]);
}


    // store: simpan input pengukuran
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

    // Ambil input lain
    $data = [
        'indikator_id' => $indikator_id,
        'user_id'      => $user_id,        // penting supaya admin bisa lihat
         'triwulan'     => $tw,  // <=== HARUS 'triwulan'
        'tahun_id'     => $tahun_id,
        'progress'     => $this->request->getPost('progress'),
        'realisasi'    => $this->request->getPost('realisasi'),
        'kendala'      => $this->request->getPost('kendala'),
        'strategi'     => $this->request->getPost('strategi'),
        'file_dukung'  => null
    ];

    // Handle file upload jika ada
    $file = $this->request->getFile('file_dukung');
    if ($file && $file->isValid() && !$file->hasMoved()) {
        $newName = $file->getRandomName();
        $file->move(FCPATH . 'uploads/pengukuran/', $newName);
        $data['file_dukung'] = $newName;
    }

    // Insert ke database
    $this->pengukuranModel->insert($data);

    return redirect()->to('/staff/task')->with('alert', [
        'type'    => 'success',
        'title'   => 'Berhasil',
        'message' => 'Pengukuran berhasil disimpan.'
    ]);
}

}
