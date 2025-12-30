<?php

namespace App\Controllers\Atasan;

use App\Controllers\BaseController;
use App\Models\PicModel;
use App\Models\IndikatorModel;
use App\Models\SasaranModel;
use App\Models\PengukuranModel;
use App\Models\TahunAnggaranModel;
use App\Models\NotificationModel;
use Dompdf\Dompdf;
use Dompdf\Options;
// Controller untuk mengelola tugas pengukuran kinerja oleh atasan
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
    $this->picModel        = new \App\Models\PicModel();
    $this->indikatorModel  = new \App\Models\IndikatorModel();
    $this->sasaranModel    = new \App\Models\SasaranModel();
    $this->pengukuranModel = new \App\Models\PengukuranModel(); // tabel: pengukuran_kinerja
    $this->tahunModel      = new \App\Models\TahunAnggaranModel();
    $this->notifModel      = new \App\Models\NotificationModel();
}


    // ============================================================
    // INDEX — TASK LIST + STATUS + PROGRESS READY
    // ============================================================
    public function index()
{
    $userId = session()->get('user_id');

    $tasks = $this->picModel
        ->select("
            pic_indikator.*,
            indikator_kinerja.nama_indikator,
            indikator_kinerja.id AS indikator_id,
            indikator_kinerja.target_tw1, indikator_kinerja.target_tw2,
            indikator_kinerja.target_tw3, indikator_kinerja.target_tw4,
            sasaran_strategis.nama_sasaran,
            tahun_anggaran.tahun,
            tahun_anggaran.id AS tahun_id
        ")
        ->join('indikator_kinerja', 'indikator_kinerja.id = pic_indikator.indikator_id')
        ->join('sasaran_strategis', 'sasaran_strategis.id = pic_indikator.sasaran_id')
        ->join('tahun_anggaran', 'tahun_anggaran.id = pic_indikator.tahun_id')
        ->where('pic_indikator.user_id', $userId)
        ->orderBy('sasaran_strategis.nama_sasaran')
        ->findAll();

    $result = [];

    foreach ($tasks as $row) {
        $tahunId = $row['tahun_id'];

        $twStatus = [
            1 => getTwStatus($tahunId, 1),
            2 => getTwStatus($tahunId, 2),
            3 => getTwStatus($tahunId, 3),
            4 => getTwStatus($tahunId, 4)
        ];

        $targetTw = [
            1 => $row['target_tw1'],
            2 => $row['target_tw2'],
            3 => $row['target_tw3'],
            4 => $row['target_tw4']
        ];

        $measurements = [];
        foreach ([1,2,3,4] as $tw) {
            $measurements[$tw] = $this->pengukuranModel
                ->where('indikator_id', $row['indikator_id'])
                ->where('triwulan', $tw)
                ->where('tahun_id', $tahunId)
                ->where('user_id', $userId) // filter PIC sendiri
                ->first();
        }

        $result[$row['nama_sasaran']][] = [
            'indikator_id' => $row['indikator_id'],
            'nama_indikator' => $row['nama_indikator'],
            'tahun' => $row['tahun'],
            'tahun_id' => $tahunId,
            'tw_status' => $twStatus,
            'target_tw' => $targetTw,
            'pengukuran' => $measurements
        ];
    }
// LOG AKTIVITAS    
    log_activity(
    'view_task_list',
    'Melihat daftar tugas pengukuran kinerja (mode atasan)',
    'task_pengukuran',
    null
);


        return view('atasan/task/index', [
            'tasksGrouped' => $result
        ]);
}


    // ============================================================
    // INPUT FORM
    // ============================================================
    public function input($indikatorId, $tw)
    {
        $userId = session()->get('user_id');

        $pic = $this->picModel
            ->select('
                pic_indikator.*,
                users.nama, users.email,
                bidang.nama_bidang, jabatan.nama_jabatan,
                sasaran_strategis.nama_sasaran,
                indikator_kinerja.nama_indikator, indikator_kinerja.satuan, indikator_kinerja.target_pk,
                indikator_kinerja.target_tw1, indikator_kinerja.target_tw2,
                indikator_kinerja.target_tw3, indikator_kinerja.target_tw4,
                tahun_anggaran.tahun
            ')
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
            return $this->failAccess();
        }

        // TW open?
        $twInfo = getTwStatus($pic['tahun_id'], $tw);
        if (!$twInfo['is_open']) {
            return $this->failTwClosed();
        }
// LOG AKTIVITAS
        log_activity(
    'open_pengukuran_form',
    "Membuka form pengukuran indikator {$pic['nama_indikator']} TW {$tw} Tahun {$pic['tahun']} (oleh atasan)",
    'indikator_kinerja',
    $indikatorId
);


        return view('atasan/task/input', [
            'indikator_id' => $indikatorId,
            'tw' => $tw,
            'pic' => $pic,
            'sasaran' => ['nama_sasaran' => $pic['nama_sasaran']],
            'indikator' => [
                'nama_indikator' => $pic['nama_indikator'],
                'satuan' => $pic['satuan'],
                'target_pk' => $pic['target_pk']
            ],
            'tahun' => $pic['tahun'],
            'target_tw' => [
                1 => $pic['target_tw1'],
                2 => $pic['target_tw2'],
                3 => $pic['target_tw3'],
                4 => $pic['target_tw4']
            ]
        ]);
    }

    // ============================================================
    // STORE INPUT
    // ============================================================
    public function store()
{
    $indikatorId = $this->request->getPost('indikator_id');
    $tw = $this->request->getPost('triwulan');
    $userId = session()->get('user_id');

    $pic = $this->picModel
        ->where('user_id', $userId)
        ->where('indikator_id', $indikatorId)
        ->first();

    if (!$pic) {
        return $this->failAccess();
    }

    $twInfo = getTwStatus($pic['tahun_id'], $tw);
    if (!$twInfo['is_open']) {
        return $this->failTwClosed();
    }

    $realisasi = $this->request->getPost('realisasi');
    $progress  = trim($this->request->getPost('progress'));
    $kendala   = trim($this->request->getPost('kendala'));
    $strategi  = trim($this->request->getPost('strategi'));

    $files = $this->request->getFiles();
    $uploaded = [];

    if (isset($files['file_dukung'])) {
        foreach ($files['file_dukung'] as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $name = $file->getRandomName();
                $file->move(FCPATH . 'uploads/pengukuran', $name);
                $uploaded[] = $name;
            }
        }
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
        'file_dukung'  => json_encode($uploaded)
    ]);

    $indikator = $this->indikatorModel->find($indikatorId);
$targetTw = $indikator['target_tw' . $tw] ?? null;
// LOG AKTIVITAS
log_activity(
    'submit_pengukuran',
    "Mengisi pengukuran indikator {$indikator['nama_indikator']} TW {$tw} Tahun {$this->tahunModel->find($pic['tahun_id'])['tahun']} dengan realisasi {$realisasi} dari target {$targetTw} (oleh atasan)",
    'pengukuran_kinerja',
    $indikatorId
);


    $this->notifModel->insert([
        'user_id' => 1,
        'message' => "PIC mengisi pengukuran indikator ID $indikatorId pada TW $tw.",
        'status'  => 'unread'
    ]);

    return redirect()->to('/atasan/task')->with('alert', [
        'type' => 'success',
        'title' => 'Berhasil',
        'message' => 'Pengukuran berhasil disimpan.'
    ]);
}


    // ============================================================
    // PROGRESS
    // ============================================================
    public function progress($indikatorId, $tw)
{
    $tahunId = $this->getTahunFromIndikator($indikatorId);
    $userId  = session()->get('user_id');

    $measure = $this->pengukuranModel
        ->where('indikator_id', $indikatorId)
        ->where('triwulan', $tw)
        ->where('tahun_id', $tahunId)
        ->where('user_id', $userId)
        ->first();

    if (!$measure) {
        return $this->fail("Belum ada pengukuran untuk TW ini.");
    }

    $indikator = $this->indikatorModel->find($indikatorId);
    $target = $indikator['target_tw' . $tw];
    $percent = $target > 0 ? ($measure['realisasi'] / $target) * 100 : 0;

// LOG AKTIVITAS
log_activity(
    'view_pengukuran_progress',
    "Melihat progress pengukuran indikator {$indikator['nama_indikator']} TW {$tw} Tahun {$this->tahunModel->find($tahunId)['tahun']} (oleh atasan)",
    'pengukuran_kinerja',
    $indikatorId
);


    return view('atasan/task/progress', [
        'measure' => $measure,
        'indikator' => $indikator,
        'target' => $target,
        'percent' => $percent,
        'tw' => $tw
    ]);
}


    // ============================================================
    // REPORT PDF — ONLY IF >= 100%
    // ============================================================
    public function report($indikatorId, $tw, $mode = 'view')
{
    $tahunId = $this->getTahunFromIndikator($indikatorId);
    $userId  = session()->get('user_id');

    $measure = $this->pengukuranModel
        ->where('indikator_id', $indikatorId)
        ->where('triwulan', $tw)
        ->where('tahun_id', $tahunId)
        ->where('user_id', $userId)
        ->first();

    if (!$measure) {
        return $this->fail("Tidak dapat membuat report.");
    }

    $indikator = $this->indikatorModel->find($indikatorId);
    $target = $indikator['target_tw' . $tw];

    if ($measure['realisasi'] < $target) {
        return $this->fail("Report hanya tersedia jika progress ≥ 100%");
    }

    $html = view('atasan/task/report_pdf', [
        'measure'   => $measure,
        'indikator' => $indikator,
        'target'    => $target,
        'tw'        => $tw
    ]);

    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $options->set('isHtml5ParserEnabled', true);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $attachment = ($mode === 'download');
// LOG AKTIVITAS
    log_activity(
    'view_pengukuran_report',
    "Melihat laporan pengukuran indikator {$indikator['nama_indikator']} TW {$tw} Tahun {$this->tahunModel->find($tahunId)['tahun']} (oleh atasan)",
    'pengukuran_kinerja',
    $indikatorId
);
if ($mode === 'download') {
    // LOG AKTIVITAS
    log_activity(
        'download_pengukuran_report',
        "Mengunduh laporan pengukuran indikator {$indikator['nama_indikator']} TW {$tw} Tahun {$this->tahunModel->find($tahunId)['tahun']} (oleh atasan)",
        'pengukuran_kinerja',
        $indikatorId
    );
}



    return $dompdf->stream(
        "Report_{$indikator['nama_indikator']}_TW{$tw}.pdf",
        ['Attachment' => $attachment]
    );
}



    // ============================================================
    // HELPER
    // ============================================================
    private function getTahunFromIndikator($indikatorId)
{
    return $this->picModel
        ->where('indikator_id', $indikatorId)
        ->first()['tahun_id'] ?? null;
}

private function fail($msg)
{
    return redirect()->back()->with('alert', [
        'type' => 'error',
        'title' => 'Gagal',
        'message' => $msg
    ]);
}

    private function failAccess()
    {
        return $this->fail("Anda tidak memiliki akses.");
    }

    private function failTwClosed()
    {
        return $this->fail("Triwulan ini sedang dikunci.");
    }
}
