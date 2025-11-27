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

    helper('globalcount');
    $pending = getPendingTaskCount($userId);

    $data = [
        'tasks' => $this->picModel->getTasksForUser($userId),
        'pending_task_count' => $pending
    ];

    return view('staff/task/index', $data);
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
    $sasaran_id   = $this->request->getPost('sasaran_id');

    // Validasi minimal
    if (!$indikator_id || !$user_id || !$tw || !$tahun_id) {
        return redirect()->back()->with('alert', [
            'type'    => 'warning',
            'title'   => 'Gagal',
            'message' => 'Data pengukuran tidak lengkap.'
        ]);
    }

    // Simpan pengukuran
    $data = [
        'indikator_id' => $indikator_id,
        'user_id'      => $user_id,
        'tw'           => $tw,
        'tahun_id'     => $tahun_id,
        'realisasi'    => $this->request->getPost('realisasi'),
        'progress'     => $this->request->getPost('progress'),
        'kendala'      => $this->request->getPost('kendala'),
        'strategi'     => $this->request->getPost('strategi'),
        'file_dukung'  => null
    ];

    // insert pengukuran
    $this->pengukuranModel->insert($data);
    $pengukuran_id = $this->pengukuranModel->getInsertID();

    // ======================================================
    // 🔔 KIRIM NOTIFIKASI KE SEMUA ADMIN (FITUR NO.4)
    // ======================================================

    $userModel  = new \App\Models\UserModel();
    $notifModel = new \App\Models\NotificationModel();

    $adminList = $userModel->where('role', 'admin')->findAll();

    foreach ($adminList as $admin) {
        $notifModel->insert([
            'user_id' => $admin['id'],
            'message' => "Staff " . session('nama') . " mengirim pengukuran baru.",
            'meta'    => json_encode([
                'indikator_id'   => $indikator_id,
                'tahun_id'       => $tahun_id,
                'sasaran_id'     => $sasaran_id,
                'tw'             => $tw,
                'submitted_by'   => $user_id,
                'pengukuran_id'  => $pengukuran_id,
                'type'           => 'pengukuran_submitted'
            ]),
            'status' => 'unread'
        ]);
    }

    // ======================================================
    // SweetAlert untuk STAFF
    // ======================================================

    return redirect()->to('/staff/task')->with('alert', [
        'type'    => 'success',
        'title'   => 'Berhasil',
        'message' => 'Pengukuran berhasil disimpan & admin menerima notifikasi.'
    ]);
}

}
