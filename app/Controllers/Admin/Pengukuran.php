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
        $this->tahunModel = new TahunAnggaranModel();
        $this->sasaranModel = new SasaranModel();
        $this->indikatorModel = new IndikatorModel();
        $this->pengukuranModel = new PengukuranModel();
    }

    // Page: selector (pilih tahun + triwulan)
    public function index()
    {
        $data['tahun'] = $this->tahunModel->orderBy('tahun','DESC')->findAll();
        return view('admin/pengukuran/index', $data);
    }

    // Ajax: load indikator & existing pengukuran untuk tahun+triwulan
    public function load()
    {
        $tahunId = $this->request->getPost('tahun_id');
        $tw = (int)$this->request->getPost('triwulan');

        if (!$tahunId || !$tw) return $this->response->setJSON(['status'=>false,'message'=>'Missing params']);

        // ambil semua sasaran -> indikator (join)
        $indikator = $this->indikatorModel
            ->select('indikator_kinerja.*, sasaran_strategis.kode_sasaran, sasaran_strategis.nama_sasaran')
            ->join('sasaran_strategis','sasaran_strategis.id = indikator_kinerja.sasaran_id','left')
            ->where('sasaran_strategis.tahun_id', $tahunId)
            ->orderBy('sasaran_strategis.id, indikator_kinerja.id')
            ->findAll();

        // ambil pengukuran existing (map by indikator_id)
        $existing = $this->pengukuranModel
            ->where('tahun_id',$tahunId)
            ->where('triwulan',$tw)
            ->findAll();

        $map = [];
        foreach($existing as $e) $map[$e['indikator_id']] = $e;

        return $this->response->setJSON(['status'=>true,'indikator'=>$indikator,'existing'=>$map]);
    }

    // Simpan (bulk atau per row). Kita terima array data
    public function store()
{
    $tahunId = $this->request->getPost('tahun_id');
    $tw = $this->request->getPost('triwulan');
    $indikator = $this->indikatorModel
        ->where('sasaran_id IN (SELECT id FROM sasaran_strategis WHERE tahun_id='.$tahunId.')', null, false)
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

        /** HANDLE FILE */
        $file = $this->request->getFile("file_$id");
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH.'uploads/pengukuran/', $newName);
            $dataSave['file_dukung'] = $newName;
        }

        /** SAVE / UPDATE */
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


    // Output view (read-only) untuk tahun+triwulan
    public function output()
    {
        $tahunId = $this->request->getGet('tahun_id') ?? null;
        $triwulan = $this->request->getGet('triwulan') ?? null;

        $data['tahun'] = $this->tahunModel->orderBy('tahun','DESC')->findAll();
        $data['selected_tahun'] = $tahunId;
        $data['selected_tw'] = $triwulan;

        if ($tahunId && $triwulan) {
            // load indikator (same as load())
            $data['indikator'] = $this->indikatorModel
                ->select('indikator_kinerja.*, sasaran_strategis.kode_sasaran, sasaran_strategis.nama_sasaran')
                ->join('sasaran_strategis','sasaran_strategis.id = indikator_kinerja.sasaran_id','left')
                ->where('sasaran_strategis.tahun_id', $tahunId)
                ->orderBy('sasaran_strategis.id, indikator_kinerja.id')
                ->findAll();

            $data['pengukuran_map'] = [];
            $existing = $this->pengukuranModel->where('tahun_id',$tahunId)->where('triwulan',$triwulan)->findAll();
            foreach($existing as $e) $data['pengukuran_map'][$e['indikator_id']] = $e;
        } else {
            $data['indikator'] = [];
            $data['pengukuran_map'] = [];
        }

        return view('admin/pengukuran/output', $data);
    }

    // Export stub (could generate PDF/Excel)
    public function export($tahunId, $tw)
    {
        // implement export (dompdf/PhpSpreadsheet) — stub:
        return $this->response->setJSON(['status'=>true,'message'=>"export for tahun:$tahunId tw:$tw"]);
    }
}
