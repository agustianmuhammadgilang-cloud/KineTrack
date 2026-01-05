<?php

namespace App\Controllers\Atasan;

use App\Controllers\BaseController;
use App\Models\Staff\GrafikKinerjaModel;

class GrafikKinerja extends BaseController
{
    protected $grafikModel;
    protected $userId;

    public function __construct()
    {
        $this->grafikModel = new GrafikKinerjaModel();
        $this->userId     = session()->get('user_id');
    }

    /* ===============================
       STEP 1 — GRAFIK TAHUN
       =============================== */
    public function index()
    {
        $grafikTahun = $this->grafikModel->getGrafikTahun($this->userId);

        // urutkan kiri → kanan (tahun lama → baru)
        $grafikTahun = array_reverse($grafikTahun);

        return view('atasan/grafik/index', [
            'grafikTahun' => $grafikTahun
        ]);
    }

    /* ===============================
       STEP 2 — GRAFIK SASARAN
       =============================== */
    public function sasaran($tahunId)
    {
        return view('atasan/grafik/sasaran', [
            'sasaran' => $this->grafikModel->getGrafikSasaran($tahunId, $this->userId),
            'tahunId' => $tahunId
        ]);
    }

    /* ===============================
       STEP 3 — GRAFIK INDIKATOR
       =============================== */
    public function indikator($sasaranId, $tahunId)
    {
        return view('atasan/grafik/indikator', [
            'indikator' => $this->grafikModel->getGrafikIndikator($sasaranId, $this->userId),
            'sasaranId' => $sasaranId,
            'tahunId'   => $tahunId
        ]);
    }

    /* ===============================
       STEP 4 — GRAFIK TRIWULAN
       =============================== */
    public function triwulan($indikatorId)
    {
        $data = $this->grafikModel->getGrafikTriwulan($indikatorId, $this->userId);

        if (!$data) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        return view('atasan/grafik/triwulan', $data);
    }
}
