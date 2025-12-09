<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TwModel;
use App\Models\TahunAnggaranModel;

class TwController extends BaseController
{
    protected $twModel;
    protected $tahunModel;

    public function __construct()
    {
        $this->twModel    = new TwModel();
        $this->tahunModel = new TahunAnggaranModel();
    }

    /**
     * Pastikan setiap tahun punya TW 1–4
     */
    private function ensureTWGenerated($tahunId)
    {
        $count = $this->twModel
            ->where('tahun_id', $tahunId)
            ->countAllResults();

        if ($count == 0) {
            for ($i = 1; $i <= 4; $i++) {
                $this->twModel->insert([
                    'tahun_id' => $tahunId,
                    'tw'       => $i,
                    'is_open'  => 0,
                    'auto_mode'=> 0
                ]);
            }
        }
    }

    public function index()
    {
        $tahunList = $this->tahunModel->findAll();

        $data = [];
        foreach ($tahunList as $t) {

            // Penting! Generate 4 TW per tahun jika belum ada
            $this->ensureTWGenerated($t['id']);

            $tw = $this->twModel
                ->where('tahun_id', $t['id'])
                ->orderBy('tw', 'ASC')
                ->findAll();

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

        // Toggle buka / kunci
        $this->twModel->update($id, [
            'is_open' => $tw['is_open'] ? 0 : 1
        ]);

        return redirect()->back()->with('alert', [
            'type' => 'success',
            'title' => 'Berhasil',
            'message' => 'Status TW berhasil diperbarui.'
        ]);
    }
}
