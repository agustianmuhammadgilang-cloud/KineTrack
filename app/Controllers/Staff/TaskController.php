<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\PicModel;
use App\Models\IndikatorModel;
use App\Models\SasaranModel;
use App\Models\PengukuranModel;
use App\Models\TahunAnggaranModel;
use App\Models\UserModel;
use App\Models\NotificationModel;

class TaskController extends BaseController
{
    protected $picModel;
    protected $indikatorModel;
    protected $sasaranModel;
    protected $pengukuranModel;
    protected $tahunModel;

    public function __construct()
    {
        $this->picModel        = new PicModel();
        $this->indikatorModel  = new IndikatorModel();
        $this->sasaranModel    = new SasaranModel();
        $this->pengukuranModel = new PengukuranModel();
        $this->tahunModel      = new TahunAnggaranModel();
    }

    // ============================================================
    // INDEX
    // ============================================================
    public function index()
    {
        $userId = session()->get('user_id');

        helper('globalcount');
        $pending = getPendingTaskCount($userId);

        return view('staff/task/index', [
            'tasks' => $this->picModel->getTasksForUser($userId),
            'pending_task_count' => $pending
        ]);
    }

    // ============================================================
    // INPUT FORM
    // ============================================================
    public function input($indikator_id)
{
    $pic = $this->picModel
        ->where('indikator_id', $indikator_id)
        ->where('user_id', session('user_id'))
        ->first();

    if (!$pic) {
        return redirect()->to('/staff/task')->with('alert', [
            'type' => 'warning',
            'title' => 'Tidak ditemukan',
            'message' => 'Anda bukan PIC indikator ini.'
        ]);
    }

    // Ambil indikator
    $indikator = $this->indikatorModel->find($indikator_id);

    // FIX: cek dulu apakah ada sasaran_id
    $sasaran = null;
    if (!empty($indikator['sasaran_id'])) {
        $sasaran = $this->sasaranModel->find($indikator['sasaran_id']);
    }

    // Tahun anggaran
    $tahunData = $this->tahunModel->find($pic['tahun_id']);
    $tahun = $tahunData['tahun'] 
          ?? $tahunData['nama_tahun']
          ?? $tahunData['tahun_anggaran']
          ?? '-';

    return view('staff/task/input', [
        'indikator_id' => $indikator_id,
        'pic'          => $pic,
        'indikator'    => $indikator,
        'sasaran'      => $sasaran,       // PASTIKAN DIKIRIM
        'tw'           => $pic['tw'],
        'tahun_id'     => $pic['tahun_id'],
        'tahun'        => $tahun
    ]);
}

    // ============================================================
    // STORE
    // ============================================================
    public function store()
{
    $indikator_id = $this->request->getPost('indikator_id');
    $user_id      = session()->get('user_id');

    // Ambil TW & Tahun berdasarkan PIC
    $pic = $this->picModel
        ->where('indikator_id', $indikator_id)
        ->where('user_id', $user_id)
        ->first();

    if (!$pic) {
        return redirect()->back()->with('alert', [
            'type' => 'danger',
            'title' => 'Gagal',
            'message' => 'PIC tidak valid.'
        ]);
    }

    $tw       = $pic['tw'];         // <-- TW BENAR AMBIL DARI PIC
    $tahun_id = $pic['tahun_id'];

    // Upload file
    $file = $this->request->getFile('file_dukung');
    $fileName = null;

    if ($file && $file->isValid() && !$file->hasMoved()) {
        $fileName = $file->getRandomName();
        $file->move('uploads/pengukuran/', $fileName);
    }

    // Insert pengukuran
    $data = [
        'indikator_id' => $indikator_id,
        'tahun_id'     => $tahun_id,
        'triwulan'     => $tw,       // <-- INI YANG MASUK KE DATABASE
        'user_id'      => $user_id,
        'realisasi'    => $this->request->getPost('realisasi'),
        'progress'     => $this->request->getPost('progress'),
        'kendala'      => $this->request->getPost('kendala'),
        'strategi'     => $this->request->getPost('strategi'),
        'file_dukung'  => $fileName
    ];

    $this->pengukuranModel->insert($data);

    return redirect()->to('/staff/task')->with('alert', [
        'type' => 'success',
        'title' => 'Berhasil',
        'message' => 'Pengukuran berhasil dikirim.'
    ]);
}
}