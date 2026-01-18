<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TahunAnggaranModel;
use App\Models\SasaranModel;
use App\Models\IndikatorModel;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;


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

    public function exportExcel()
{
    // Ambil tahun aktif
    $tahunAktif = $this->tahunModel->where('status', 'active')->first();

    $sasaran = $this->sasaranModel
        ->where('tahun_id', $tahunAktif['id'])
        ->findAll();

    $indikator = $this->indikatorModel->findAll();

    // =========================
    // GROUP INDIKATOR PER SASARAN
    // =========================
    $indikatorBySasaran = [];
    foreach ($indikator as $i) {
        $indikatorBySasaran[$i['sasaran_id']][] = $i;
    }

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Perjanjian Kinerja');

    // =========================
    // HEADER JUDUL
    // =========================
    $sheet->mergeCells('A1:I1');
    $sheet->setCellValue('A1', 'PERJANJIAN KINERJA TAHUN ' . $tahunAktif['tahun']);
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // =========================
    // HEADER TABEL
    // =========================
    $headerRow = 3;
    $headers = [
        'A' => 'No',
        'B' => 'Sasaran Strategis',
        'C' => 'Indikator Kinerja',
        'D' => 'Satuan',
        'E' => 'Target PK',
        'F' => 'TW 1',
        'G' => 'TW 2',
        'H' => 'TW 3',
        'I' => 'TW 4',
    ];

    foreach ($headers as $col => $text) {
        $sheet->setCellValue($col . $headerRow, $text);
    }

    $sheet->getStyle("A{$headerRow}:I{$headerRow}")->applyFromArray([
        'font' => [
            'bold' => true,
            'color' => ['rgb' => 'FFFFFF']
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => '003366']
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN
            ]
        ]
    ]);

    // =========================
    // ISI DATA
    // =========================
    $row = $headerRow + 1;
    $no = 1;

    foreach ($sasaran as $s) {

        $indikatorList = $indikatorBySasaran[$s['id']] ?? [];

        foreach ($indikatorList as $i) {
            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", $s['nama_sasaran']);
            $sheet->setCellValue("C{$row}", $i['nama_indikator']);
            $sheet->setCellValue("D{$row}", $i['satuan']);
            $sheet->setCellValue("E{$row}", $i['target_pk']);
            $sheet->setCellValue("F{$row}", $i['target_tw1']);
            $sheet->setCellValue("G{$row}", $i['target_tw2']);
            $sheet->setCellValue("H{$row}", $i['target_tw3']);
            $sheet->setCellValue("I{$row}", $i['target_tw4']);

            $sheet->getStyle("A{$row}:I{$row}")->getBorders()->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            $row++;
        }

        $no++;
    }

    // =========================
    // AUTO WIDTH
    // =========================
    foreach (range('A', 'I') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // =========================
    // LOG AKTIVITAS
    // =========================
    log_activity(
        'EXPORT_PERJANJIAN_KINERJA_EXCEL',
        'Admin mengekspor Perjanjian Kinerja tahun ' . $tahunAktif['tahun'] . ' dalam format Excel.',
        'perjanjian_kinerja',
        $tahunAktif['id']
    );

    // =========================
    // DOWNLOAD
    // =========================
    $filename = 'perjanjian_kinerja_' . $tahunAktif['tahun'] . '_' . date('Ymd_His') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}

}
