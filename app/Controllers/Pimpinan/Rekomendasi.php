<?php

namespace App\Controllers\Pimpinan;

use App\Controllers\BaseController;
use App\Models\RekomendasiPengukuranModel;
use App\Models\TahunAnggaranModel;

class Rekomendasi extends BaseController
{
    protected $rekomendasiModel;
    protected $tahunModel;

    public function __construct()
    {
        $this->rekomendasiModel = new RekomendasiPengukuranModel();
        $this->tahunModel       = new TahunAnggaranModel();
    }

    // ====================================================
    // FORM REKOMENDASI (TAB / HALAMAN)
    // ====================================================
    public function form()
{
    $tahunId = $this->request->getGet('tahun_id');
    $tw      = $this->request->getGet('triwulan');

    // Pastikan data tahun terpilih diambil untuk label di view
    $data['tahun_detail'] = $this->tahunModel->find($tahunId);
    $data['tahun_teks'] = $data['tahun_detail']['tahun'] ?? '';

    $data['tahun'] = $this->tahunModel->orderBy('tahun', 'DESC')->findAll();
    $data['selected_tahun'] = $tahunId;
    $data['selected_tw']    = $tw;
    $data['rekomendasi'] = null;

    if ($tahunId && $tw) {
        $data['rekomendasi'] = $this->rekomendasiModel->getByPeriode($tahunId, $tw);
    }
    
    log_activity(
    'view_form_rekomendasi',
    "Pimpinan membuka form rekomendasi" .
    ($tahunId && $tw ? " TW $tw tahun {$data['tahun_teks']}" : ''),
    'rekomendasi_pengukuran',
    null
);


    return view('pimpinan/rekomendasi/form', $data);
}

    // ====================================================
    // SIMPAN / UPDATE REKOMENDASI
    // ====================================================
    public function store()
    {
        $tahunId = $this->request->getPost('tahun_id');
        $tw      = $this->request->getPost('triwulan');
        $isi     = trim($this->request->getPost('isi_rekomendasi'));

        if (!$tahunId || !$tw || empty($isi)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Semua field wajib diisi.');
        }

        // cek apakah sudah ada rekomendasi
        $existing = $this->rekomendasiModel
            ->getByPeriode($tahunId, $tw);

        $tahunData = $this->tahunModel->find($tahunId);
        $tahunText = $tahunData['tahun'] ?? '-';

        if ($existing) {

            // UPDATE
            $this->rekomendasiModel->update($existing['id'], [
                'isi_rekomendasi' => $isi,
                'pimpinan_id'     => session('user_id'),
            ]);

            log_activity(
                'update_rekomendasi',
                "Pimpinan mengupdate rekomendasi TW $tw tahun $tahunText",
                'rekomendasi_pengukuran',
                $existing['id']
            );

            return redirect()->back()
                ->with('success', 'Rekomendasi berhasil diperbarui.');
        }

        // INSERT
        $id = $this->rekomendasiModel->insert([
            'tahun_id'        => $tahunId,
            'triwulan'        => $tw,
            'isi_rekomendasi' => $isi,
            'pimpinan_id'     => session('user_id'),
        ]);

        log_activity(
            'create_rekomendasi',
            "Pimpinan membuat rekomendasi TW $tw tahun $tahunText",
            'rekomendasi_pengukuran',
            $id
        );

        return redirect()->back()
            ->with('success', 'Rekomendasi berhasil disimpan.');
    }
}
