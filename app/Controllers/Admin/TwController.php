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
        $currentTw = $this->getCurrentTW(); // TW berdasarkan bulan saat ini

        for ($i = 1; $i <= 4; $i++) {
            $this->twModel->insert([
                'tahun_id' => $tahunId,
                'tw'       => $i,
                'is_open'  => ($i == $currentTw) ? 1 : 0, // default terbuka untuk TW saat ini
                'auto_mode'=> 1 // aktifkan auto_mode untuk penanda
            ]);
        }
    }
}


    public function index()
    {
        $tahunList = $this->tahunModel
            ->where('status', 'active')
            ->orderBy('tahun', 'DESC')
            ->findAll();

        $currentTw = $this->getCurrentTW();

        $data = [];
        foreach ($tahunList as $t) {

            $this->ensureTWGenerated($t['id']);

            $twList = $this->twModel
                ->where('tahun_id', $t['id'])
                ->orderBy('tw', 'ASC')
                ->findAll();

            foreach ($twList as &$tw) {

                // --- Hanya penanda TW aktif otomatis (highlight) ---
                $tw['is_auto_now'] = ($tw['tw'] == $currentTw) ? 1 : 0;

                // --- Status terbuka/tertutup berdasarkan manual override ---
                $tw['is_open_effective'] = ($tw['is_open'] == 1) ? 1 : 0;
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

    $newStatus = $tw['is_open'] ? 0 : 1;

    $this->twModel->update($id, [
        'is_open' => $newStatus
    ]);

    // 🔥 LOG AKTIVITAS
    log_activity(
        'toggle_triwulan',
        'Mengubah status TW ' . $tw['tw'] . ' menjadi ' . ($newStatus ? 'TERBUKA' : 'TERKUNCI'),
        'tw_settings',
        $id
    );

    return redirect()->back()->with('alert', [
        'type' => 'success',
        'title' => 'Berhasil',
        'message' => 'Status TW berhasil diperbarui.'
    ]);
}

}
