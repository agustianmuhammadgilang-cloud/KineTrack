<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\PicModel;
use App\Models\IndikatorModel;
use App\Models\SasaranModel;
use App\Models\PengukuranModel;
use App\Models\TahunAnggaranModel;
use App\Models\NotificationModel;

class TaskController extends BaseController
{
    protected $picModel;
    protected $indikatorModel;
    protected $sasaranModel;
    protected $pengukuranModel;
    protected $tahunModel;
    protected $notifModel;

    public function __construct()
    {
        $this->picModel        = new PicModel();
        $this->indikatorModel  = new IndikatorModel();
        $this->sasaranModel    = new SasaranModel();
        $this->pengukuranModel = new PengukuranModel();
        $this->tahunModel      = new TahunAnggaranModel();
        $this->notifModel      = new NotificationModel();
    }


    // ============================================================
    // INDEX — FINAL & COMPATIBLE WITH FRONTEND
    // ============================================================
    public function index()
    {
        $userId = session()->get('user_id');

        // Ambil semua indikator milik user
        $tasks = $this->picModel
            ->select('
                pic_indikator.*,
                indikator_kinerja.nama_indikator, indikator_kinerja.id AS indikator_id,
                sasaran_strategis.nama_sasaran,
                tahun_anggaran.tahun,
                tahun_anggaran.id AS tahun_id
            ')
            ->join('indikator_kinerja', 'indikator_kinerja.id = pic_indikator.indikator_id')
            ->join('sasaran_strategis', 'sasaran_strategis.id = pic_indikator.sasaran_id')
            ->join('tahun_anggaran', 'tahun_anggaran.id = pic_indikator.tahun_id')
            ->where('pic_indikator.user_id', $userId)
            ->orderBy('sasaran_strategis.nama_sasaran')
            ->findAll();

        $result = [];

        foreach ($tasks as $row) {

            $tahunId = $row['tahun_id'];

            // FIX: gunakan helper final
            $twStatus = [
                1 => getTwStatus($tahunId, 1),
                2 => getTwStatus($tahunId, 2),
                3 => getTwStatus($tahunId, 3),
                4 => getTwStatus($tahunId, 4),
            ];

            $result[$row['nama_sasaran']][] = [
                'indikator_id'   => $row['indikator_id'],
                'nama_indikator' => $row['nama_indikator'],
                'tahun'          => $row['tahun'],
                'tahun_id'       => $tahunId,
                'tw_status'      => $twStatus
            ];
        }

        return view('staff/task/index', [
            'tasksGrouped' => $result
        ]);
    }


    // ============================================================
    // INPUT
    // ============================================================
    public function input($indikatorId, $tw)
    {
        $userId = session()->get('user_id');

        $pic = $this->picModel
            ->select('pic_indikator.*,
                      users.nama, users.email,
                      bidang.nama_bidang, jabatan.nama_jabatan,
                      sasaran_strategis.nama_sasaran,
                      indikator_kinerja.nama_indikator, indikator_kinerja.satuan, indikator_kinerja.target_pk,
                      tahun_anggaran.tahun')
            ->join('users', 'users.id = pic_indikator.user_id')
            ->join('bidang', 'bidang.id = users.bidang_id')
            ->join('jabatan', 'jabatan.id = users.jabatan_id')
            ->join('indikator_kinerja', 'indikator_kinerja.id = pic_indikator.indikator_id')
            ->join('sasaran_strategis', 'sasaran_strategis.id = pic_indikator.sasaran_id')
            ->join('tahun_anggaran', 'tahun_anggaran.id = pic_indikator.tahun_id')
            ->where('pic_indikator.user_id', $userId)
            ->where('pic_indikator.indikator_id', $indikatorId)
            ->first();

        if (!$pic) {
            return redirect()->to('/staff/task')->with('alert', [
                'type' => 'error',
                'title' => 'Akses Ditolak',
                'message' => 'Anda tidak memiliki akses pada indikator ini.'
            ]);
        }

        // Final check TW
        $twInfo = getTwStatus($pic['tahun_id'], $tw);
        if (!$twInfo['is_open']) {
            return redirect()->to('/staff/task')->with('alert', [
                'type' => 'error',
                'title' => 'TW Terkunci',
                'message' => 'Triwulan ini tidak dibuka untuk input.'
            ]);
        }

        return view('staff/task/input', [
            'indikator_id' => $indikatorId,
            'tw'           => $tw,
            'pic'          => $pic,
            'sasaran'      => ['nama_sasaran' => $pic['nama_sasaran']],
            'indikator'    => [
                'nama_indikator' => $pic['nama_indikator'],
                'satuan'         => $pic['satuan'],
                'target_pk'      => $pic['target_pk']
            ],
            'tahun'        => $pic['tahun']
        ]);
    }


    // ============================================================
    // STORE
    // ============================================================
    public function store()
    {
        $indikatorId = $this->request->getPost('indikator_id');
        $tw          = $this->request->getPost('triwulan');
        $userId      = session()->get('user_id');

        $pic = $this->picModel
            ->where('user_id', $userId)
            ->where('indikator_id', $indikatorId)
            ->first();

        if (!$pic) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Akses Ditolak',
                'message' => 'Anda tidak memiliki hak input pada indikator ini.'
            ]);
        }

        // Final TW check
        $twInfo = getTwStatus($pic['tahun_id'], $tw);
        if (!$twInfo['is_open']) {
            return redirect()->to('/staff/task')->with('alert', [
                'type' => 'error',
                'title' => 'TW Terkunci',
                'message' => 'Input pada TW ini tidak diperbolehkan.'
            ]);
        }

        $realisasi = $this->request->getPost('realisasi');
        $progress  = trim($this->request->getPost('progress'));
        $kendala   = trim($this->request->getPost('kendala'));
        $strategi  = trim($this->request->getPost('strategi'));

        $file = $this->request->getFile('file_dukung');
        $fileName = null;
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/pengukuran', $fileName);
        }

        $this->pengukuranModel->insert([
            'indikator_id' => $indikatorId,
            'triwulan'     => $tw,
            'tahun_id'     => $pic['tahun_id'],
            'user_id'      => $userId,
            'realisasi'    => $realisasi,
            'progress'     => $progress,
            'kendala'      => $kendala,
            'strategi'     => $strategi,
            'file_dukung'  => $fileName
        ]);

        // notif ke admin
        $this->notifModel->insert([
            'user_id' => 1,
            'message' => "PIC mengisi pengukuran indikator ID $indikatorId pada TW $tw.",
            'status'  => 'unread'
        ]);

        return redirect()->to('/staff/task')->with('alert', [
            'type' => 'success',
            'title' => 'Berhasil',
            'message' => 'Pengukuran berhasil disimpan.'
        ]);
    }
}
