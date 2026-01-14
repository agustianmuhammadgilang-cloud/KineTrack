<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TahunAnggaranModel;
use App\Models\SasaranModel;
use App\Models\IndikatorModel;
use Dompdf\Dompdf;

class PerjanjianKinerja extends BaseController
{
    protected $tahunModel;
    protected $sasaranModel;
    protected $indikatorModel;

    public function __construct()
    {
        $this->tahunModel = new TahunAnggaranModel();
        $this->sasaranModel = new SasaranModel();
        $this->indikatorModel = new IndikatorModel();
    }

    public function index()
    {
        // Ambil tahun aktif
        $tahunAktif = $this->tahunModel->where('status','active')->first();

        // Ambil semua sasaran tahun aktif
        $sasaran = $this->sasaranModel->where('tahun_id', $tahunAktif['id'])->findAll();

        // Ambil semua indikator
        $indikator = $this->indikatorModel->findAll();

        $data = [
            'tahunAktif' => $tahunAktif,
            'sasaran' => $sasaran,
            'indikator' => $indikator
        ];

        return view('admin/perjanjian_kinerja/index', $data);
    }

    public function exportPdf()
    {
        $tahunAktif = $this->tahunModel->where('status','active')->first();
        $sasaran = $this->sasaranModel->where('tahun_id', $tahunAktif['id'])->findAll();
        $indikator = $this->indikatorModel->findAll();

        $data = [
            'tahunAktif' => $tahunAktif,
            'sasaran' => $sasaran,
            'indikator' => $indikator
        ];

        $html = view('admin/perjanjian_kinerja/pdf', $data);

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = 'perjanjian_kinerja_' . date('Ymd_His') . '.pdf';
        log_activity(
    'EXPORT_PERJANJIAN_KINERJA',
    'Admin mengekspor dokumen Perjanjian Kinerja untuk tahun ' . $tahunAktif['tahun'] . ' dalam format PDF.',
    'perjanjian_kinerja',
    $tahunAktif['id']
);

        return $dompdf->stream($filename, ['Attachment' => true]);
    }
}
