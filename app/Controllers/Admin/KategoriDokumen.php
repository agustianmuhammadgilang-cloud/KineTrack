<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriDokumenModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Controller untuk mengelola kategori dokumen
class KategoriDokumen extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriDokumenModel();
    }

    // ============================
    // LIST KATEGORI
    // ============================
public function index()
{
    $keyword = $this->request->getGet('q');

    $kategori = $keyword
        ? $this->kategoriModel->searchAdmin($keyword)
        : $this->kategoriModel->findAll();

    return view('admin/kategori/index', [
        'title'    => 'Kategori Dokumen',
        'kategori' => $kategori,
        'keyword'  => $keyword
    ]);
}

    // ============================
    // FORM TAMBAH
    // ============================
    public function create()
    {
        return view('admin/kategori/create', [
            'title' => 'Tambah Kategori Dokumen'
        ]);
    }

    // ============================
    // SIMPAN
    // ============================
    public function store()
{
    $data = [
        'nama_kategori' => $this->request->getPost('nama_kategori'),
        'deskripsi'     => $this->request->getPost('deskripsi'),
        'status'        => 'aktif',
        'created_by'    => session()->get('user_id')
    ];

    $kategoriId = $this->kategoriModel->insert($data);

    // LOG AKTIVITAS
    log_activity(
        'create_kategori_dokumen',
        "Menambahkan kategori dokumen '{$data['nama_kategori']}'",
        'kategori_dokumen',
        $kategoriId
    );

    return redirect()->to('/admin/kategori-dokumen')
        ->with('success', 'Kategori berhasil ditambahkan');
}


    // ============================
    // FORM EDIT
    // ============================
    public function edit($id)
    {
        $kategori = $this->kategoriModel->find($id);

        if (!$kategori) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }

        return view('admin/kategori/edit', [
            'title'    => 'Edit Kategori Dokumen',
            'kategori' => $kategori
        ]);
    }

    // ============================
    // UPDATE
    // ============================
    public function update($id)
    {
        $this->kategoriModel->update($id, [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'deskripsi'     => $this->request->getPost('deskripsi')
        ]);

        $this->kategoriModel->update($id, $dataBaru);

        //LOG AKTIVITAS
    log_activity(
        'update_kategori_dokumen',
        'Memperbarui kategori dokumen dari "' . $kategoriLama['nama_kategori'] .
        '" menjadi "' . $dataBaru['nama_kategori'] . '"',
        'kategori_dokumen',
        $id
    );

        return redirect()->to('/admin/kategori-dokumen')
                         ->with('success', 'Kategori berhasil diperbarui');
    }

    // ============================
    // AKTIF / NONAKTIF
    // ============================
    public function toggleStatus($id)
{
    $kategori = $this->kategoriModel->find($id);

    if (!$kategori) {
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    if ($kategori['status'] !== 'aktif' && $kategori['status'] !== 'nonaktif') {
        return redirect()->back()
            ->with('error', 'Kategori ini tidak bisa diubah statusnya');
    }

    $statusBaru = $kategori['status'] === 'aktif' ? 'nonaktif' : 'aktif';

    $this->kategoriModel->update($id, [
        'status' => $statusBaru
    ]);

    //LOG AKTIVITAS
    log_activity(
        'toggle_kategori_dokumen',
        'Mengubah status kategori dokumen "' . $kategori['nama_kategori'] .
        '" menjadi ' . strtoupper($statusBaru),
        'kategori_dokumen',
        $id
    );

    return redirect()->back()
        ->with('success', 'Status kategori diperbarui');
}

public function export()
{
    $kategoriModel = new \App\Models\KategoriDokumenModel();
    $dokumenModel  = new \App\Models\DokumenModel();

    $kategoriList = $kategoriModel->findAll();

    $statusMap = [
        'resmi'   => 'RESMI',
        'pending' => 'PENDING',
        'reject'  => 'REJECT',
    ];

    $data = [
        'kategoriList' => $kategoriList,
        'statusMap'    => $statusMap,
        'dokumenModel' => $dokumenModel,
    ];

    $html = view('admin/kategori/export', $data);

    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $filename = 'export-dokumen-' . date('Ymd_His') . '.pdf';
    /**
     * =====================================================
     * 🔥 ACTIVITY LOG — EXPORT DOKUMEN
     * =====================================================
     * Human-readable, audit-ready, scalable
     */
    log_activity(
        'EXPORT_DOKUMEN_PDF',
        'Admin mengekspor daftar dokumen ke file PDF melalui menu kategori dokumen.',
        'dokumen'
    );
    return $dompdf->stream($filename, ['Attachment' => true]);
}

public function exportExcel()
{
    if (session()->get('role') !== 'admin') {
        return redirect()->back();
    }

    $kategoriModel = new \App\Models\KategoriDokumenModel();
    $dokumenModel  = new \App\Models\DokumenModel();

    $kategoriList = $kategoriModel->findAll();

    $statusMap = [
        'resmi'   => 'RESMI',
        'pending' => 'PENDING',
        'reject'  => 'REJECT',
    ];

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Kategori & Dokumen');

    // =====================
    // JUDUL
    // =====================
    $sheet->mergeCells('A1:C1');
    $sheet->setCellValue('A1', 'LAPORAN KATEGORI & DOKUMEN');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A1')->getAlignment()
          ->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // =====================
    // HEADER
    // =====================
    $headerRow = 3;
    $sheet->fromArray(
        ['Kategori', 'Nama Dokumen', 'Status Dokumen'],
        null,
        "A{$headerRow}"
    );

    $sheet->getStyle("A{$headerRow}:C{$headerRow}")->applyFromArray([
        'font' => [
            'bold' => true,
            'color' => ['rgb' => 'FFFFFF']
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => '1D2F83']
        ],
        'borders' => [
            'allBorders' => ['borderStyle' => Border::BORDER_THIN]
        ]
    ]);

    // =====================
    // ISI DATA
    // =====================
    $row = $headerRow + 1;

    foreach ($kategoriList as $kategori) {

        $dokumenList = $dokumenModel
            ->where('kategori_id', $kategori['id'])
            ->findAll();

        if (empty($dokumenList)) {
            $sheet->setCellValue("A{$row}", $kategori['nama_kategori']);
            $sheet->setCellValue("B{$row}", '-');
            $sheet->setCellValue("C{$row}", '-');
            $row++;
            continue;
        }

        foreach ($dokumenList as $dok) {
            $sheet->setCellValue("A{$row}", $kategori['nama_kategori']);
            $sheet->setCellValue("B{$row}", $dok['judul']);
            $sheet->setCellValue(
                "C{$row}",
                $statusMap[$dok['status']] ?? strtoupper($dok['status'])
            );

            $sheet->getStyle("A{$row}:C{$row}")
                  ->getBorders()
                  ->getAllBorders()
                  ->setBorderStyle(Border::BORDER_THIN);

            $sheet->getStyle("C{$row}")
                  ->getAlignment()
                  ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $row++;
        }
    }

    // =====================
    // AUTO WIDTH
    // =====================
    foreach (['A','B','C'] as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // =====================
    // LOG AKTIVITAS
    // =====================
    log_activity(
        'EXPORT_DOKUMEN_EXCEL',
        'Admin mengekspor kategori beserta dokumen ke format Excel.',
        'dokumen'
    );

    // =====================
    // DOWNLOAD
    // =====================
    $filename = 'Kategori_Dokumen_' . date('Ymd_His') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}



}
