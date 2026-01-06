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
    $listTahun  = $this->grafikModel->getListTahun();
    $tahunAktif = $this->grafikModel->getTahunAktif();

    if (!$tahunAktif) {
        throw new \RuntimeException('Tahun aktif tidak ditemukan');
    }

    $indikator = $this->grafikModel
        ->getGrafikIndikatorByTahun($tahunAktif['id']);

    return view('admin/grafik/index', [
        'listTahun'  => $listTahun,
        'tahunAktif' => $tahunAktif,
        'indikator'  => $indikator
    ]);
}

public function dataIndikator($tahunId)
{
    $data = $this->grafikModel->getGrafikIndikatorByTahun($tahunId);

    return $this->response->setJSON($data);
}


    /* ===============================
       STEP 2 — GRAFIK TRIWULAN
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
