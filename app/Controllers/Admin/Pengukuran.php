<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TahunAnggaranModel;
use App\Models\SasaranModel;
use App\Models\IndikatorModel;
use App\Models\PengukuranModel;

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

    // ===========================
    // PAGE: INPUT PENGUKURAN
    // ===========================
    public function index()
    {
        $data['tahun'] = $this->tahunModel->orderBy('tahun','DESC')->findAll();
        return view('admin/pengukuran/index', $data);
    }


    // ===========================
    // AJAX LOAD INDIKATOR
    // ===========================
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

        // 🔥 Ambil indikator berdasarkan tahun + triwulan SASARAN
        $indikator = $this->indikatorModel
            ->select('indikator_kinerja.*, sasaran_strategis.nama_sasaran')
            ->join('sasaran_strategis', 'sasaran_strategis.id = indikator_kinerja.sasaran_id')
            ->where('sasaran_strategis.tahun_id', $tahunId)
            ->where('sasaran_strategis.triwulan', $tw)
            ->orderBy('sasaran_strategis.id', 'ASC')
            ->orderBy('indikator_kinerja.id', 'ASC')
            ->findAll();

        // 🔥 Ambil data pengukuran existing
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


    // ===========================
    // SIMPAN BULK INPUT
    // ===========================
    public function store()
    {
        $tahunId = $this->request->getPost('tahun_id');
        $tw      = $this->request->getPost('triwulan');

        // Ambil indikator berdasarkan tahun saja (triwulan bukan indikator)
        $indikator = $this->indikatorModel
    ->select('indikator_kinerja.id')
    ->join('sasaran_strategis', 'sasaran_strategis.id = indikator_kinerja.sasaran_id')
    ->where('sasaran_strategis.tahun_id', $tahunId)
    ->where('sasaran_strategis.triwulan', $tw) // <- tambahkan filter triwulan
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

            // FILE UPLOAD
            $file = $this->request->getFile("file_$id");
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH.'uploads/pengukuran/', $newName);
                $dataSave['file_dukung'] = $newName;
            }

            // UPDATE / INSERT
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


    // ===========================
    // OUTPUT / READ ONLY
    // ===========================
    public function output()
{
    $tahunId  = $this->request->getGet('tahun_id');
    $tw       = $this->request->getGet('triwulan');

    $data['tahun'] = $this->tahunModel->orderBy('tahun','DESC')->findAll();
    $data['selected_tahun'] = $tahunId;
    $data['selected_tw']    = $tw;

    if ($tahunId && $tw) {

        // Ambil indikator yang sesuai tahun + triwulan sasaran
        $data['indikator'] = $this->indikatorModel
            ->select('indikator_kinerja.*, sasaran_strategis.kode_sasaran, sasaran_strategis.nama_sasaran')
            ->join('sasaran_strategis','sasaran_strategis.id = indikator_kinerja.sasaran_id')
            ->where('sasaran_strategis.tahun_id', $tahunId)
            ->where('sasaran_strategis.triwulan', $tw)  // ✅ filter triwulan
            ->orderBy('sasaran_strategis.id')
            ->orderBy('indikator_kinerja.id')
            ->findAll();

        // Ambil data pengukuran existing untuk TW tersebut
        $map = [];
        $existing = $this->pengukuranModel
            ->where('tahun_id',$tahunId)
            ->where('triwulan',$tw)
            ->findAll();

        foreach ($existing as $e) {
            $map[$e['indikator_id']] = $e;
        }

        $data['pengukuran_map'] = $map;
    } 
    else {
        $data['indikator'] = [];
        $data['pengukuran_map'] = [];
    }

    return view('admin/pengukuran/output', $data);
}



    // ===========================
    // EXPORT PLACEHOLDER
    // ===========================
    public function export($tahunId, $tw)
    {
        return $this->response->setJSON([
            'status'  => true,
            'message' => "export tahun:$tahunId tw:$tw"
        ]);
    }
}