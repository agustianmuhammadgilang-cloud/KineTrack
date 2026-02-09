<?php

namespace App\Controllers\Pimpinan;

use App\Controllers\BaseController;
use App\Models\PicModel;
use App\Models\IndikatorModel;
use App\Models\DokumenModel;
use App\Models\TahunAnggaranModel;

class Dashboard extends BaseController
{
    public function __construct()
    {
        if (session()->get('role') !== 'pimpinan') {
            redirect()->to('/login')->send();
            exit;
        }
    }

    public function index()
    {
        $picModel        = new PicModel();
        $indikatorModel  = new IndikatorModel();
        $dokumenModel    = new DokumenModel();
        $tahunModel      = new TahunAnggaranModel();

        /* ===============================
         * TAHUN ANGGARAN AKTIF
         * =============================== */
        $tahunAktif = $tahunModel
            ->where('status', 'active')
            ->first();

        /* ===============================
         * CARD 1 — TOTAL PIC
         * =============================== */
        $totalPic = $picModel->countAllResults();

        /* ===============================
         * CARD 2 — JUMLAH INDIKATOR (TAHUN AKTIF)
         * =============================== */
        /* ===============================
 * CARD 2 — JUMLAH INDIKATOR (TAHUN AKTIF)
 * =============================== */
$totalIndikator = 0;

if ($tahunAktif) {
    $totalIndikator = $indikatorModel
        ->join(
            'sasaran_strategis',
            'sasaran_strategis.id = indikator_kinerja.sasaran_id'
        )
        ->where('sasaran_strategis.tahun_id', $tahunAktif['id'])
        ->countAllResults();
}


        /* ===============================
         * CARD 3 — JUMLAH DOKUMEN
         * =============================== */
        $totalDokumen = $dokumenModel->countAllResults();

        /* ===============================
         * KIRIM KE VIEW
         * =============================== */
        return view('pimpinan/dashboard/index', [
            'title'           => 'Dashboard Pimpinan',
            'totalPic'        => $totalPic,
            'totalIndikator'  => $totalIndikator,
            'totalDokumen'    => $totalDokumen,
        ]);
    }
}
