<?php

namespace App\Controllers\Pimpinan;

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
        $this->tahunModel      = new TahunAnggaranModel();
        $this->sasaranModel    = new SasaranModel();
        $this->indikatorModel  = new IndikatorModel();
        $this->pengukuranModel = new PengukuranModel();
    }

    // ================================================================
    // OUTPUT PENGUKURAN (READ ONLY)
    // ================================================================
    public function output()
    {
        $tahunId = $this->request->getGet('tahun_id');
        $tw      = $this->request->getGet('triwulan');

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

           $tahunData = $this->tahunModel->find($tahunId);

// SAFE GUARD 🔥
$tahunNama = $tahunData['tahun'] ?? 'Tidak diketahui';
// LOG ACTIVITY
log_activity(
    'view_pengukuran_pimpinan',
    "Pimpinan melihat output pengukuran TW $tw Tahun $tahunNama",
    'pengukuran_kinerja',
    $tahunId
);


        } else {
            $data['indikator'] = [];
            $data['pengukuran_map'] = [];
        }

        return view('pimpinan/pengukuran/output', $data);
    }

    // ================================================================
    // DETAIL (READ ONLY)
    // ================================================================
    public function detail($indikator_id, $tahun_id, $tw)
    {
        $indikator = $this->indikatorModel
            ->select('indikator_kinerja.*, sasaran_strategis.nama_sasaran')
            ->join('sasaran_strategis', 'sasaran_strategis.id = indikator_kinerja.sasaran_id')
            ->where('indikator_kinerja.id', $indikator_id)
            ->first();

        if (!$indikator) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Indikator tidak ditemukan');
        }

        $tahunData = $this->tahunModel->find($tahun_id);

        $pengukuran = $this->pengukuranModel
            ->select('pengukuran_kinerja.*, users.nama as user_nama')
            ->join('users', 'users.id = pengukuran_kinerja.user_id', 'left')
            ->where('indikator_id', $indikator_id)
            ->where('tahun_id', $tahun_id)
            ->where('triwulan', $tw)
            ->orderBy('updated_at', 'DESC')
            ->findAll();

        log_activity(
            'view_detail_pengukuran_pimpinan',
            "Pimpinan melihat detail indikator $indikator_id TW $tw",
            'indikator_kinerja',
            $indikator_id
        );

        return view('pimpinan/pengukuran/detail_output', [
            'indikator'  => $indikator,
            'pengukuran' => $pengukuran,
            'tahun'      => $tahunData['tahun'] ?? '-',
            'tw'         => $tw,
            'tahun_id'   => $tahun_id
        ]);
    }
}
