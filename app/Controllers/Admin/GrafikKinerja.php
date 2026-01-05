<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GrafikKinerjaModel;

class GrafikKinerja extends BaseController
{
    protected $grafikModel;

    public function __construct()
    {
        $this->grafikModel = new GrafikKinerjaModel();
    }

    /* ===============================
       STEP 1 — GRAFIK TAHUN (INDEX)
       =============================== */
    public function index()
{
    $grafikTahun = $this->grafikModel->getGrafikTahun();

    // biar kiri → kanan (lama → aktif)
    $grafikTahun = array_reverse($grafikTahun);

    return view('admin/grafik/index', [
        'grafikTahun' => $grafikTahun
    ]);
}



    /* ===============================
       STEP 2 — GRAFIK SASARAN
       =============================== */
    public function sasaran($tahunId)
    {
        $sasaran = $this->grafikModel->getGrafikSasaran($tahunId);

        return view('admin/grafik/sasaran', [
            'sasaran' => $sasaran,
            'tahunId' => $tahunId
        ]);
    }

    /* ===============================
       STEP 3 — GRAFIK INDIKATOR
       =============================== */
public function indikator($sasaranId, $tahunId)
{
    $indikator = $this->grafikModel->getGrafikIndikator($sasaranId);

    return view('admin/grafik/indikator', [
        'indikator' => $indikator,
        'sasaranId' => $sasaranId,
        'tahunId'   => $tahunId
    ]);
}



    /* ===============================
       STEP 4 — GRAFIK TRIWULAN
       =============================== */
    public function triwulan($indikatorId)
    {
        $data = $this->grafikModel->getGrafikTriwulan($indikatorId);

        if (!$data) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Indikator tidak ditemukan');
        }

        return view('admin/grafik/triwulan', $data);
    }
}
