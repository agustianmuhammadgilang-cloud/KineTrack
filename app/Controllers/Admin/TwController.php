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
     * Hitung TW otomatis berdasarkan bulan saat ini
     * Jan–Mar = 1, Apr–Jun = 2, Jul–Sep = 3, Okt–Des = 4
     */
    private function getCurrentTW()
    {
        $bulan = (int) date('n'); 
        return ceil($bulan / 3);
    }

    /**
     * Pastikan setiap tahun punya 4 TW
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
                    'is_open'  => 0, // default tertutup
                    'auto_mode'=> 0
                ]);
            }
        }
    }

    public function index()
{
    // ==========================================
    // HANYA TAHUN DENGAN STATUS = 'active'
    // ==========================================
    $tahunList = $this->tahunModel
        ->where('status', 'active')
        ->orderBy('tahun', 'DESC')
        ->findAll();

    $currentTw = $this->getCurrentTW();

    $data = [];
    foreach ($tahunList as $t) {

        // generate default 4 TW jika belum ada
        $this->ensureTWGenerated($t['id']);

        $twList = $this->twModel
            ->where('tahun_id', $t['id'])
            ->orderBy('tw', 'ASC')
            ->findAll();

        foreach ($twList as &$tw) {

            // --- AUTO OPEN LOGIC ---
            $tw['is_auto_open_now'] = (
                $tw['auto_mode'] == 1 &&
                $tw['tw'] == $currentTw
            ) ? 1 : 0;

            // --- FINAL OPEN STATE (AUTO + MANUAL) ---
            $tw['is_open_effective'] = (
                $tw['is_open'] == 1 ||
                $tw['is_auto_open_now'] == 1
            ) ? 1 : 0;
        }

        $data[] = [
            'tahun' => $t['tahun'],
            'tw'    => $twList
        ];
    }

    return view('admin/tw/index', [
        'data' => $data
    ]);
}



    /**
     * Admin membuka / mengunci TW (manual override)
     */
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
