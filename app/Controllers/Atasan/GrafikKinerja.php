<?php

namespace App\Controllers\Atasan;

use App\Controllers\BaseController;
use App\Models\GrafikKinerjaStaffModel;

class GrafikKinerja extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new GrafikKinerjaStaffModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');

        $tahunAktif = $this->model->getTahunAktif();
        $listTahun  = $this->model->getListTahun();
        $indikator  = $this->model->getIndikatorByTahun($tahunAktif['id'], $userId);

        return view('atasan/grafik/index', [
            'tahunAktif' => $tahunAktif,
            'listTahun'  => $listTahun,
            'indikator'  => $indikator
        ]);
    }

    public function dataIndikator($tahunId)
    {
        $userId = session()->get('user_id');

        return $this->response->setJSON(
            $this->model->getIndikatorByTahun($tahunId, $userId)
        );
    }

    public function triwulan($indikatorId)
    {
        $userId = session()->get('user_id');

        // 🔑 PAKAI METHOD LAMA (BENAR)
        $data = $this->model->getGrafikTriwulan($indikatorId, $userId);

        if (!$data) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        return view('atasan/grafik/triwulan', $data);
    }
}
