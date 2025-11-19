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
        $post = $this->request->getPost();
        $userId = session('user_id');
        $createdBy = session('user_id');

        $saved = 0;
        if (!isset($post['rows'])) {
            return redirect()->back()->with('error','Tidak ada data');
        }

        $rows = json_decode($post['rows'], true);
        foreach ($rows as $r) {
            if (!isset($r['indikator_id'])) continue;

            $indikatorId = (int)$r['indikator_id'];
            $tahunId = (int)$r['tahun_id'];
            $tw = (int)$r['triwulan'];
            $realisasi = ($r['realisasi'] === '' ? null : (float)$r['realisasi']);
            $target = (float) ($r['target'] ?? 0);

            // hitung progress (simple)
            $progress = null;
            if ($target > 0 && $realisasi !== null) {
                $progress = round((($realisasi / $target) * 100), 2);
            }

            // cek existing
            $exist = $this->pengukuranModel->where('indikator_id',$indikatorId)
                ->where('tahun_id',$tahunId)
                ->where('triwulan',$tw)
                ->first();

            $dataSave = [
                'indikator_id'=>$indikatorId,
                'tahun_id'=>$tahunId,
                'triwulan'=>$tw,
                'user_id'=> $r['user_id'] ?? null,
                'realisasi'=>$realisasi,
                'progress'=>$progress,
                'kendala'=>$r['kendala'] ?? null,
                'strategi'=>$r['strategi'] ?? null,
                'data_dukung'=>$r['data_dukung'] ?? null,
                'created_by'=>$createdBy
            ];

            if ($exist) {
                $this->pengukuranModel->update($exist['id'],$dataSave);
            } else {
                $this->pengukuranModel->insert($dataSave);
            }
            $saved++;
        }

        return redirect()->back()->with('success', "$saved baris tersimpan.");
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
