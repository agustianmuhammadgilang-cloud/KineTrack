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
    // INDEX — TASK LIST + STATUS + PROGRESS READY
    // ============================================================
    public function index()
{
    $userId = session()->get('user_id'); // ⬅️ WAJIB

    $tasks = $this->picModel
        ->select("
            pic_indikator.*,
            indikator_kinerja.nama_indikator,
            indikator_kinerja.id AS indikator_id,
            indikator_kinerja.target_tw1, indikator_kinerja.target_tw2,
            indikator_kinerja.target_tw3, indikator_kinerja.target_tw4,
            sasaran_strategis.nama_sasaran,
            tahun_anggaran.tahun,
            tahun_anggaran.id AS tahun_id,
            users.nama AS pic_nama
        ")
        ->join('indikator_kinerja', 'indikator_kinerja.id = pic_indikator.indikator_id')
        ->join('sasaran_strategis', 'sasaran_strategis.id = pic_indikator.sasaran_id')
        ->join('tahun_anggaran', 'tahun_anggaran.id = pic_indikator.tahun_id')
        ->join('users', 'users.id = pic_indikator.user_id')
        ->where('pic_indikator.user_id', $userId) // ✅ INI KUNCINYA
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
                ->where('user_id', $userId)
                ->first();
        }

        $result[$row['nama_sasaran']][] = [
            'indikator_id'   => $row['indikator_id'],
            'nama_indikator'=> $row['nama_indikator'],
            'tahun'          => $row['tahun'],
            'tahun_id'       => $tahunId,
            'tw_status'      => $twStatus,
            'target_tw'      => $targetTw,
            'pengukuran'     => $measurements,
            'pic'            => ['nama' => $row['pic_nama']]
        ];
    }

    return view('atasan/task/index', [
        'tasksGrouped' => $result
    ]);
}

    // ============================================================
    // FORM INPUT
    // ============================================================
    public function input($indikator_id, $tw)
    {
        // Ambil PIC terkait indikator
        $pic = $this->picModel->where('indikator_id', $indikator_id)->first();
        if (!$pic) {
            return $this->failAccess();
        }

        $indikator = $this->indikatorModel->find($indikator_id);
        $sasaran   = $this->sasaranModel->find($indikator['sasaran_id']);

        // Ambil tahun_id dari PIC, fallback ke tahun terbaru
        $tahun_id = $pic['tahun_id'] ?? null;
        if (!$tahun_id) {
            $tahunData = $this->tahunModel->orderBy('tahun', 'DESC')->first();
            $tahun_id = $tahunData['id'] ?? null;
        }

        $tahun = $this->tahunModel->find($tahun_id)['tahun'] ?? date('Y');

        $target_tw = [
            1 => $indikator['target_tw1'],
            2 => $indikator['target_tw2'],
            3 => $indikator['target_tw3'],
            4 => $indikator['target_tw4']
        ];

        return view('atasan/task/input', compact('indikator_id', 'indikator', 'sasaran', 'tahun', 'tahun_id', 'tw', 'pic', 'target_tw'));
    }

    // ============================================================
    // STORE INPUT
    // ============================================================
    public function store()
    {
        $indikator_id = $this->request->getPost('indikator_id');
        $triwulan     = $this->request->getPost('triwulan');

        // Ambil PIC terkait
        $pic = $this->picModel->where('indikator_id', $indikator_id)->first();
        if (!$pic) {
            return $this->failAccess();
        }

        $tahun_id = $pic['tahun_id'] ?? null;
        if (!$tahun_id) {
            $tahunData = $this->tahunModel->orderBy('tahun', 'DESC')->first();
            $tahun_id = $tahunData['id'] ?? null;
        }

        $data = [
            'indikator_id' => $indikator_id,
            'triwulan'     => $triwulan,
            'tahun_id'     => $tahun_id,
            'user_id'      => $pic['user_id'],
            'realisasi'    => $this->request->getPost('realisasi'),
            'progress'     => $this->request->getPost('progress'),
            'kendala'      => $this->request->getPost('kendala'),
            'strategi'     => $this->request->getPost('strategi'),
            'file_dukung'  => null
        ];

        // Handle multiple files
        $files = $this->request->getFiles();
        $fileDukung = [];
        if (!empty($files['file_dukung'])) {
            foreach ($files['file_dukung'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(WRITEPATH.'uploads/pengukuran', $newName);
                    $fileDukung[] = $newName;
                }
            }
        }
        $data['file_dukung'] = json_encode($fileDukung);

        $this->pengukuranModel->insert($data);

        return redirect()->to(base_url('atasan/task'))
            ->with('success', 'Pengukuran berhasil disimpan.');
    }

    // ============================================================
    // PROGRESS
    // ============================================================
    public function progress($indikator_id, $tw)
    {
        $pic = $this->picModel->where('indikator_id', $indikator_id)->first();
        if (!$pic) {
            return $this->failAccess();
        }

        $measure = $this->pengukuranModel
            ->where('indikator_id', $indikator_id)
            ->where('triwulan', $tw)
            ->where('tahun_id', $pic['tahun_id'])
            ->where('user_id', $pic['user_id'])
            ->first();

        $indikator = $this->indikatorModel->find($indikator_id);
        $target    = $indikator['target_tw'.$tw] ?? 0;
        $percent   = ($target > 0 && $measure) ? ($measure['realisasi']/$target)*100 : 0;

        return view('atasan/task/progress', compact('indikator','measure','percent','tw','target'));
    }

    // ============================================================
    // REPORT PDF
    // ============================================================
    public function report_pdf($indikator_id, $tw)
    {
        $pic = $this->picModel->where('indikator_id', $indikator_id)->first();
        if (!$pic) return $this->failAccess();

        $measure = $this->pengukuranModel
            ->where('indikator_id', $indikator_id)
            ->where('triwulan', $tw)
            ->where('tahun_id', $pic['tahun_id'])
            ->where('user_id', $pic['user_id'])
            ->first();

        $indikator = $this->indikatorModel->find($indikator_id);
        $target    = $indikator['target_tw'.$tw] ?? 0;

        $dompdf = new Dompdf();
        $html = view('atasan/task/report_pdf', compact('indikator','measure','tw','target'));
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4','portrait');
        $dompdf->render();
        $dompdf->stream("Laporan_Pengukuran_TW$tw.pdf", ["Attachment" => false]);
    }

    // ============================================================
    // HELPERS
    // ============================================================
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
}
