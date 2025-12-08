<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TwModel;
use App\Models\TahunModel;

class TwController extends BaseController
{
    protected $twModel;
    protected $tahunModel;

    public function __construct()
    {
        $this->twModel    = new TwModel();
        $this->tahunModel = new TahunModel();
    }

    public function index()
    {
        $tahunList = $this->tahunModel->findAll();

        $data = [];
        foreach ($tahunList as $t) {
            $tw = $this->twModel->where('tahun_id', $t['id'])->findAll();

            $data[] = [
                'tahun' => $t['tahun'],
                'tw'    => $tw
            ];
        }

        return view('admin/tw/index', [
            'data' => $data
        ]);
    }

    public function toggle($id)
    {
        $tw = $this->twModel->find($id);

        if (!$tw) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Error',
                'message' => 'Data TW tidak ditemukan!'
            ]);
        }

        // Toggle status
        $newStatus = $tw['is_open'] ? 0 : 1;

        $this->twModel->update($id, [
            'is_open' => $newStatus
        ]);

        return redirect()->back()->with('alert', [
            'type' => 'success',
            'title' => 'Berhasil',
            'message' => "Status TW berhasil diperbarui."
        ]);
    }
}
