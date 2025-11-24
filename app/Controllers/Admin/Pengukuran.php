<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TahunAnggaranModel;
use App\Models\SasaranModel;
use App\Models\IndikatorModel;
use App\Models\PengukuranModel;
use XLSXWriter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Pengukuran extends BaseController
{
    protected $tahunModel;
    protected $sasaranModel;
    protected $indikatorModel;
    protected $pengukuranModel;

    public function __construct()
    {
        $this->tahunModel       = new TahunAnggaranModel();
        $this->sasaranModel     = new SasaranModel();
        $this->indikatorModel   = new IndikatorModel();
        $this->pengukuranModel  = new PengukuranModel();
    }


    // ================================================================
    // PAGE: INPUT PENGUKURAN
    // ================================================================
    public function index()
    {
        $data['tahun'] = $this->tahunModel->orderBy('tahun', 'DESC')->findAll();
        return view('admin/pengukuran/index', $data);
    }


    // ================================================================
    // AJAX LOAD INDIKATOR
    // ================================================================
    public function load()
    {
        $tahunId = $this->request->getPost('tahun_id');
        $tw      = (int)$this->request->getPost('triwulan');

        if (!$tahunId || !$tw) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Parameter tidak lengkap'
            ]);
        }

        // Ambil indikator berdasarkan tahun + triwulan sasaran
        $indikator = $this->indikatorModel
            ->select('indikator_kinerja.*, sasaran_strategis.nama_sasaran')
            ->join('sasaran_strategis', 'sasaran_strategis.id = indikator_kinerja.sasaran_id')
            ->where('sasaran_strategis.tahun_id', $tahunId)
            ->where('sasaran_strategis.triwulan', $tw)
            ->orderBy('sasaran_strategis.id', 'ASC')
            ->orderBy('indikator_kinerja.id', 'ASC')
            ->findAll();

        // Data pengukuran existing
        $existing = $this->pengukuranModel
            ->where('tahun_id', $tahunId)
            ->where('triwulan', $tw)
            ->findAll();

        $map = [];
        foreach ($existing as $e) {
            $map[$e['indikator_id']] = $e;
        }

        return $this->response->setJSON([
            'status'    => true,
            'indikator' => $indikator,
            'existing'  => $map
        ]);
    }


    // ================================================================
    // SIMPAN BULK INPUT
    // ================================================================
    public function store()
    {
        $tahunId = $this->request->getPost('tahun_id');
        $tw      = $this->request->getPost('triwulan');

        $indikator = $this->indikatorModel
            ->select('indikator_kinerja.id')
            ->join('sasaran_strategis', 'sasaran_strategis.id = indikator_kinerja.sasaran_id')
            ->where('sasaran_strategis.tahun_id', $tahunId)
            ->where('sasaran_strategis.triwulan', $tw)
            ->findAll();

        $saveCount = 0;

        foreach ($indikator as $ind) {

            $id = $ind['id'];

            $dataSave = [
                'indikator_id' => $id,
                'tahun_id'     => $tahunId,
                'triwulan'     => $tw,
                'realisasi'    => $this->request->getPost("realisasi_$id"),
                'kendala'      => $this->request->getPost("kendala_$id"),
                'strategi'     => $this->request->getPost("strategi_$id"),
                'data_dukung'  => $this->request->getPost("data_dukung_$id"),
                'created_by'   => session('user_id')
            ];

            // Upload File
            $file = $this->request->getFile("file_$id");
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/pengukuran/', $newName);
                $dataSave['file_dukung'] = $newName;
            }

            // Insert / Update
            $existing = $this->pengukuranModel
                ->where('indikator_id', $id)
                ->where('tahun_id', $tahunId)
                ->where('triwulan', $tw)
                ->first();

            if ($existing) {
                $this->pengukuranModel->update($existing['id'], $dataSave);
            } else {
                $this->pengukuranModel->insert($dataSave);
            }

            $saveCount++;
        }

        return redirect()->back()->with('success', "$saveCount data berhasil disimpan");
    }


    // ================================================================
    // OUTPUT / READ ONLY
    // ================================================================
    public function output()
    {
        $tahunId = $this->request->getGet('tahun_id');
        $tw      = $this->request->getGet('triwulan');

        // Tahun hanya yang aktif!
        $data['tahun'] = $this->tahunModel
            ->where('status', 'active')
            ->orderBy('tahun', 'DESC')
            ->findAll();

        $data['selected_tahun'] = $tahunId;
        $data['selected_tw']    = $tw;

        if ($tahunId && $tw) {

            $data['indikator'] = $this->indikatorModel
                ->select('indikator_kinerja.*, sasaran_strategis.kode_sasaran, sasaran_strategis.nama_sasaran')
                ->join('sasaran_strategis', 'sasaran_strategis.id = indikator_kinerja.sasaran_id')
                ->where('sasaran_strategis.tahun_id', $tahunId)
                ->where('sasaran_strategis.triwulan', $tw)
                ->orderBy('sasaran_strategis.id')
                ->orderBy('indikator_kinerja.id')
                ->findAll();

            $existing = $this->pengukuranModel
                ->where('tahun_id', $tahunId)
                ->where('triwulan', $tw)
                ->findAll();

            $map = [];
            foreach ($existing as $e) {
                $map[$e['indikator_id']] = $e;
            }

            $data['pengukuran_map'] = $map;
        } else {
            $data['indikator'] = [];
            $data['pengukuran_map'] = [];
        }

        return view('admin/pengukuran/output', $data);
    }


    // ================================================================
    // DETAIL
    // ================================================================
    public function detail($indikator_id, $tahun_id, $tw)
    {
        $indikator = $this->indikatorModel
            ->select('indikator_kinerja.*, sasaran_strategis.nama_sasaran')
            ->join('sasaran_strategis', 'sasaran_strategis.id = indikator_kinerja.sasaran_id')
            ->where('indikator_kinerja.id', $indikator_id)
            ->first();

        if (!$indikator) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Indikator tidak ditemukan");
        }

        $pengukuran = $this->pengukuranModel
            ->where('indikator_id', $indikator_id)
            ->where('tahun_id', $tahun_id)
            ->where('triwulan', $tw)
            ->first();

    return view('admin/pengukuran/detail_output', [
        'indikator'  => $indikator,
        'pengukuran' => $pengukuran,
        'tahun_id'   => $tahun_id,
        'tw'         => $tw
    ]);
}

public function export($tahunId, $tw)
{
    // =============== 1. AMBIL DATA INDIKATOR (tanpa join PIC supaya tidak duplikat) ===============
    $indikator = $this->indikatorModel
        ->select('indikator_kinerja.*, sasaran_strategis.kode_sasaran, sasaran_strategis.nama_sasaran')
        ->join('sasaran_strategis', 'sasaran_strategis.id = indikator_kinerja.sasaran_id')
        ->where('sasaran_strategis.tahun_id', $tahunId)
        ->where('sasaran_strategis.triwulan', $tw)
        ->orderBy('sasaran_strategis.id')
        ->orderBy('indikator_kinerja.id')
        ->findAll();

    // jika kosong, keluar cepat
    if (empty($indikator)) {
        return $this->response->setJSON(['status'=>false,'message'=>'Tidak ada indikator untuk tahun/triwulan ini.']);
    }

    // kumpulkan semua id indikator untuk query PIC selanjutnya
    $indikatorIds = array_column($indikator, 'id');

    // =============== 2. AMBIL PENGUKURAN (nilai) ===============
    $pengukuran = $this->pengukuranModel
        ->where('tahun_id', $tahunId)
        ->where('triwulan', $tw)
        ->findAll();

    $mapPengukuran = [];
    foreach ($pengukuran as $p) {
        $mapPengukuran[$p['indikator_id']] = $p;
    }

    // =============== 3. AMBIL PIC (nama + jabatan) PER INDIKATOR ===============
    $db = \Config\Database::connect();
    $builder = $db->table('pic_indikator');
    $picRows = $builder
        ->select('pic_indikator.indikator_id, users.nama as pic_nama, jabatan.nama_jabatan as pic_jabatan')
        ->join('users','users.id = pic_indikator.user_id','left')
        ->join('jabatan','jabatan.id = pic_indikator.jabatan_id','left')
        ->whereIn('pic_indikator.indikator_id', $indikatorIds)
        ->get()
        ->getResultArray();

    // buat map: indikator_id => [ "Nama — Jabatan", ... ]
    $picMap = [];
    foreach ($picRows as $r) {
        $label = trim(($r['pic_nama'] ?? '-'));
        $jab = trim(($r['pic_jabatan'] ?? '-'));
        $combined = $label;
        if (!empty($jab) && $jab !== '-') $combined .= ' — ' . $jab;
        $picMap[$r['indikator_id']][] = $combined;
    }

    // untuk setiap indikator gabungkan PIC array jadi string tunggal (dipisah ; )
    foreach ($picMap as $k => $arr) {
        $picMap[$k] = implode('; ', array_unique($arr));
    }

    // =============== 4. INISIALISASI XLSX WRITER ===============
    $writer = new XLSXWriter();
    $sheetName = "TW $tw";

    $header = [
        'Kode Sasaran'      => 'string',
        'Nama Sasaran'      => 'string',
        'Kode Indikator'    => 'string',
        'Nama Indikator'    => 'string',
        'PIC (Nama — Jabatan)' => 'string',
        'Target'            => 'string',
        'Capaian'           => 'string',
        'Kendala Strategis' => 'string',
        'Data Dukung'       => 'string',
    ];

    $headerStyle = [
        'font-style' => 'bold',
        'halign' => 'center',
        'widths' => [15, 30, 15, 35, 30, 15, 15, 30, 30]
    ];

    $writer->writeSheetHeader($sheetName, $header, $headerStyle);

    // =============== 5. LOOPING ISI ROWS ===============
    foreach ($indikator as $ind) {
        $indId = $ind['id'];

        $nilai = $mapPengukuran[$indId]['realisasi'] ?? ($mapPengukuran[$indId]['nilai'] ?? '-');
        $kendala = $mapPengukuran[$indId]['kendala'] ?? '-';
        $dataDukung = $mapPengukuran[$indId]['data_dukung'] ?? '-';

        $picLabel = $picMap[$indId] ?? '-';

        $row = [
            $ind['kode_sasaran'] ?? '-',
            $ind['nama_sasaran'] ?? '-',
            $ind['kode_indikator'] ?? '-',
            $ind['nama_indikator'] ?? '-',
            $picLabel,
            (string)($ind['target_pk'] ?? '-'),
            (string)$nilai,
            $kendala,
            $dataDukung
        ];

        $writer->writeSheetRow($sheetName, $row);
    }

    // =============== 6. OUTPUT FILE ===============
    $fileName = "Output_Pengukuran_Tahun{$tahunId}_TW{$tw}.xlsx";

    header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($fileName).'"');
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');

    $writer->writeToStdOut();
    exit;
}

    
}