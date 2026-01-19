<?php

namespace App\Controllers\Atasan;

use App\Controllers\BaseController;
use App\Models\DokumenModel;
use App\Models\BidangModel;
use App\Models\NotificationModel;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

// Controller untuk mengelola dokumen oleh atasan (kaprodi/kajur)
class Dokumen extends BaseController
{
    protected $dokumenModel;
    protected $bidangModel;
    protected $notifModel;

    public function __construct()
    {
        $this->dokumenModel = new DokumenModel();
        $this->bidangModel  = new BidangModel();
        $this->notifModel   = new NotificationModel();
    }

    /**
     * =================================
     * DAFTAR DOKUMEN MASUK (KAPRODI / KAJUR)
     * =================================
     */
    public function index()
    {
        $role     = session()->get('role');
        $bidangId = session()->get('bidang_id');

        if ($role !== 'atasan' || !$bidangId) {
            return redirect()->back()->with('error', 'Akses tidak diizinkan');
        }

        $bidangUser = $this->bidangModel->find($bidangId);
        if (!$bidangUser) {
            return redirect()->back()->with('error', 'Unit kerja tidak valid');
        }

        // =========================
        // KETUA PRODI
        // =========================
        if ($bidangUser['parent_id'] !== null) {
            $dokumen = $this->dokumenModel
                ->where('status', 'pending_kaprodi')
                ->where('unit_asal_id', $bidangUser['id'])
                ->orderBy('created_at', 'DESC')
                ->findAll();
        }
        // =========================
        // KETUA JURUSAN
        // =========================
        else {
            $dokumen = $this->dokumenModel
                ->where('status', 'pending_kajur')
                ->where('unit_jurusan_id', $bidangUser['id'])
                ->orderBy('created_at', 'DESC')
                ->findAll();
        }
// LOG AKTIVITAS
        log_activity(
    'view_dokumen_masuk',
    'Melihat daftar dokumen masuk untuk direview',
    'dokumen',
    null
);


        return view('atasan/dokumen/index', [
            'dokumen' => $dokumen
        ]);
    }

    /**
     * =================================
     * DETAIL / REVIEW DOKUMEN
     * =================================
     */
    public function review($id)
    {
        $dokumen = $this->dokumenModel->find($id);

        if (!$dokumen) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan');
        }

        if (!$this->canReview($dokumen)) {
            return redirect()->back()->with('error', 'Anda tidak berhak mereview dokumen ini');
        }

        log_activity(
    'review_dokumen',
    "Membuka review dokumen '{$dokumen['judul']}'",
    'dokumen',
    $dokumen['id']
);


        return view('atasan/dokumen/review', [
            'dokumen' => $dokumen
        ]);
    }

    /**
     * =================================
     * APPROVE DOKUMEN
     * =================================
     */
    public function approve($id)
{
    $dokumen = $this->dokumenModel->find($id);

    if (!$dokumen || !$this->canReview($dokumen)) {
        return redirect()->back()->with('error', 'Aksi tidak valid');
    }

    $bidangId   = session()->get('bidang_id');
    $bidangUser = $this->bidangModel->find($bidangId);

    /**
     * =========================
     * KETUA PRODI
     * =========================
     */
    if ($dokumen['status'] === 'pending_kaprodi') {

        $this->dokumenModel->update($id, [
            'status'           => 'pending_kajur',
            'current_reviewer' => 'kajur',
            'catatan'          => null,
            'updated_at'       => date('Y-m-d H:i:s'),
            'is_viewed_by_atasan' => 0
        ]);

        // 🔔 NOTIF KE KAJUR
        $kajurList = model('UserModel')
            ->where('role', 'atasan')
            ->where('bidang_id', $dokumen['unit_jurusan_id'])
            ->findAll();

        foreach ($kajurList as $kajur) {
            $this->notifModel->insert([
                'user_id' => $kajur['id'],
                'message' => 'Dokumen "' . $dokumen['judul'] . '" telah disetujui Kaprodi dan menunggu persetujuan Anda.',
                'meta'    => json_encode([
                    'dokumen_id' => $dokumen['id'],
                    'type'       => 'approve_forward'
                ]),
                'status' => 'unread',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * =========================
     * KETUA JURUSAN (FINAL)
     * =========================
     */
    elseif ($dokumen['status'] === 'pending_kajur') {

        $updateData = [
            'status'           => 'archived',
            'current_reviewer' => null,
            'catatan'          => null,
            'updated_at'       => date('Y-m-d H:i:s'),
            
        ];

        if ($dokumen['scope'] === 'public') {
            $updateData['published_at'] = date('Y-m-d H:i:s');
        }

        $this->dokumenModel->update($id, $updateData);

        // 🔔 NOTIF KE STAFF
        $this->notifModel->insert([
            'user_id' => $dokumen['created_by'],
            'message' => 'Dokumen "' . $dokumen['judul'] . '" telah disetujui dan diarsipkan.',
            'meta'    => json_encode([
                'dokumen_id' => $dokumen['id'],
                'type'       => 'approve_final'
            ]),
            'status' => 'unread',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    // 🔔 NOTIF KE ATASAN SENDIRI
    $this->notifModel->insert([
        'user_id' => session()->get('user_id'),
        'message' => 'Anda berhasil menyetujui dokumen "' . $dokumen['judul'] . '".',
        'meta'    => json_encode([
            'dokumen_id' => $dokumen['id'],
            'type'       => 'approve_success'
        ]),
        'status' => 'unread',
        'created_at' => date('Y-m-d H:i:s')
    ]);

    log_activity(
        'approve_dokumen',
        "Menyetujui dokumen '{$dokumen['judul']}'",
        'dokumen',
        $dokumen['id']
    );

    return redirect()->to('/atasan/dokumen')
        ->with('success', 'Dokumen berhasil disetujui');
}




    /**
     * =================================
     * REJECT DOKUMEN
     * =================================
     */
    public function reject($id)
{
    $dokumen = $this->dokumenModel->find($id);

    if (!$dokumen || !$this->canReview($dokumen)) {
        return redirect()->back()->with('error', 'Aksi tidak valid');
    }

    $catatan = $this->request->getPost('catatan');
    if (!$catatan) {
        return redirect()->back()->with('error', 'Catatan penolakan wajib diisi');
    }

    $bidangId   = session()->get('bidang_id');
    $bidangUser = $this->bidangModel->find($bidangId);

    if ($bidangUser['parent_id'] !== null) {
        $statusReject = 'rejected_kaprodi';
        $penolak     = 'Ketua Program Studi';
    } else {
        $statusReject = 'rejected_kajur';
        $penolak     = 'Ketua Jurusan';
    }

    $this->dokumenModel->update($id, [
        'status'           => $statusReject,
        'current_reviewer' => null,
        'catatan'          => $catatan,
        'updated_at'       => date('Y-m-d H:i:s')
    ]);

    // 🔔 NOTIF KE STAFF
    $this->notifModel->insert([
        'user_id' => $dokumen['created_by'],
        'message' => 'Dokumen "' . $dokumen['judul'] . '" ditolak oleh ' . $penolak . '. Silakan lakukan revisi.',
        'meta'    => json_encode([
            'dokumen_id' => $dokumen['id'],
            'type'       => 'dokumen_reject'
        ]),
        'status' => 'unread',
        'created_at' => date('Y-m-d H:i:s')
    ]);

    // 🔔 NOTIF KE ATASAN SENDIRI
    $this->notifModel->insert([
        'user_id' => session()->get('user_id'),
        'message' => 'Dokumen "' . $dokumen['judul'] . '" berhasil ditolak dan dikembalikan ke staff.',
        'meta'    => json_encode([
            'dokumen_id' => $dokumen['id'],
            'type'       => 'reject_success'
        ]),
        'status' => 'unread',
        'created_at' => date('Y-m-d H:i:s')
    ]);

    log_activity(
        'reject_dokumen',
        "Menolak dokumen '{$dokumen['judul']}'",
        'dokumen',
        $dokumen['id']
    );

    return redirect()->to('/atasan/dokumen')
        ->with('success', 'Dokumen berhasil ditolak');
}



    /**
     * =================================
     * VALIDASI HAK REVIEW
     * =================================
     */
    private function canReview(array $dokumen): bool
{
    // Hanya atasan
    if (session()->get('role') !== 'atasan') {
        return false;
    }

    $bidangId = session()->get('bidang_id');
    if (!$bidangId) {
        return false;
    }

    $bidangUser = $this->bidangModel->find($bidangId);
    if (!$bidangUser) {
        return false;
    }

    /**
     * =========================
     * KETUA PRODI
     * =========================
     * HANYA:
     * - status pending_kaprodi
     * - dokumen dari unit sendiri
     */
    if ($bidangUser['parent_id'] !== null) {
        return $dokumen['status'] === 'pending_kaprodi'
            && $dokumen['unit_asal_id'] == $bidangUser['id'];
    }

    /**
     * =========================
     * KETUA JURUSAN
     * =========================
     */
    if ($dokumen['status'] !== 'pending_kajur') {
        return false;
    }

    /**
     *  DOKUMEN PUBLIC
     * Kajur BOLEH review SEMUA dokumen public
     * di jurusannya (lintas prodi)
     */
    if ($dokumen['scope'] === 'public') {
        return $dokumen['unit_jurusan_id'] == $bidangUser['id'];
    }

    /**
     *  DOKUMEN NON-PUBLIC (unit / personal)
     * Tetap ketat
     */
    return $dokumen['unit_jurusan_id'] == $bidangUser['id'];
}


    /**
     * =================================
     * ARSIP DOKUMEN (HANYA KAJUR)
     * =================================
     */
    public function arsip()
{
    if (session()->get('role') !== 'atasan') {
        return redirect()->back();
    }

    $bidangId = session()->get('bidang_id');
    $bidang   = $this->bidangModel->find($bidangId);

    if (!$bidang) {
        return redirect()->back();
    }

    // ======================
    // FILTER INPUT (FINAL)
    // ======================
    $date = $this->request->getGet('date'); // format: YYYY-MM-DD
    $q    = $this->request->getGet('q');    // judul dokumen

    // ============================
    // KETUA JURUSAN (FULL ARSIP)
    // ============================
    if ($bidang['parent_id'] === null) {

        $data['dokumen'] = $this->dokumenModel
            ->where('status', 'archived')
            ->where('unit_jurusan_id', $bidangId)
            ->orderBy('updated_at', 'DESC')
            ->findAll();
    }

    // ============================
    // KETUA PRODI (READ ONLY)
    // ============================
    else {

        $data['dokumen'] = $this->dokumenModel
            ->where('status', 'archived')
            ->where('unit_jurusan_id', $bidang['parent_id']) // 🔥 KUNCI
            ->where('unit_asal_id', $bidangId)
            ->orderBy('updated_at', 'DESC')
            ->findAll();
    }

    // ======================
    // FILTER DATA (PHP LEVEL)
    // TANPA UBAH LOGIKA QUERY
    // ======================
    $data['dokumen'] = array_filter($data['dokumen'], function ($d) use ($date, $q) {

        // FILTER TANGGAL (updated_at)
        if ($date) {
            if (date('Y-m-d', strtotime($d['updated_at'])) !== $date) {
                return false;
            }
        }

        // FILTER JUDUL
        if ($q && stripos($d['judul'], $q) === false) {
            return false;
        }

        return true;
    });

    // ======================
    // LOG AKTIVITAS
    // ======================
    log_activity(
        'search_filter_dokumen_arsip',
        'Melakukan pencarian dan filter arsip dokumen',
        'dokumen',
        null
    );

    return view('atasan/dokumen/arsip', $data);
}




/**
 * =================================
 * DOKUMEN UNIT (READ ONLY)
 * =================================
 */
public function unit()
{
    if (session()->get('role') !== 'atasan') {
        return redirect()->back();
    }

    $bidangId = session()->get('bidang_id');
    if (!$bidangId) {
        return redirect()->back();
    }

    // ======================
    // FILTER INPUT
    // ======================
    $q        = $this->request->getGet('q');        // judul dokumen
    $pengirim = $this->request->getGet('pengirim');
    $unit     = $this->request->getGet('unit');

    // DATA ASLI (JANGAN DIUBAH)
    $dokumen = $this->dokumenModel->getDokumenUnit($bidangId);

    // ======================
    // FILTER DI PHP (AMAN)
    // ======================
    $dokumen = array_filter($dokumen, function ($d) use ($q, $pengirim, $unit) {

        if ($q && stripos($d['judul'], $q) === false) {
            return false;
        }

        if ($pengirim && stripos($d['nama_pengirim'] ?? '', $pengirim) === false) {
            return false;
        }

        if ($unit && stripos($d['nama_unit'] ?? '', $unit) === false) {
            return false;
        }

        return true;
    });

    log_activity(
        'search_filter_dokumen_unit_atasan',
        'Melakukan pencarian dan filter dokumen unit (atasan)',
        'dokumen',
        null
    );

    return view('atasan/dokumen/unit', [
        'dokumen' => $dokumen
    ]);
}


//
public function public()
{
    if (session()->get('role') !== 'atasan') {
        return redirect()->back()->with('error', 'Akses tidak diizinkan');
    }

    // ======================
    // FILTER INPUT
    // ======================
    $q        = $this->request->getGet('q');
    $pengirim = $this->request->getGet('pengirim');
    $unit     = $this->request->getGet('unit');

    // DATA ASLI
    $dokumen = $this->dokumenModel->getDokumenPublic();

    // ======================
    // FILTER DI PHP
    // ======================
    $dokumen = array_filter($dokumen, function ($d) use ($q, $pengirim, $unit) {

        if ($q && stripos($d['judul'], $q) === false) {
            return false;
        }

        if ($pengirim && stripos($d['nama_pengirim'] ?? '', $pengirim) === false) {
            return false;
        }

        if ($unit && stripos($d['nama_unit'] ?? '', $unit) === false) {
            return false;
        }

        return true;
    });

    log_activity(
        'search_filter_dokumen_public_atasan',
        'Melakukan pencarian dan filter dokumen publik (atasan)',
        'dokumen',
        null
    );

    return view('atasan/dokumen/public', [
        'dokumen' => $dokumen
    ]);
}


 public function exportArsipPdf()
{
    $userId = session()->get('user_id');
    $bidangId = session()->get('bidang_id'); // gunakan bidan_id, bukan unit_id
    if (!$userId || !$bidangId) {
        return redirect()->to('/login');
    }

    // Ambil semua dokumen arsip unit atasan
    $dokumen = $this->dokumenModel->getDokumenUnit($bidangId);

    // Render view menjadi HTML
    $html = view('atasan/dokumen/export_pdf', ['dokumen' => $dokumen]);

    // Inisialisasi Dompdf
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Nama file PDF
    $filename = 'arsip_dokumen_atasan_' . date('Ymd_His') . '.pdf';
     /**
     * ======================================
     * LOG AKTIVITAS (EXPORT ARSIP)
     * ======================================
     */
    log_activity(
        'EXPORT_ARSIP_DOKUMEN',
        'Mengunduh arsip dokumen unit/bidang dalam bentuk PDF',
        'dokumen_arsip',
        null
    );

    // Download PDF
    return $dompdf->stream($filename, ['Attachment' => true]);
}


public function exportArsipExcel()
{
    if (session()->get('role') !== 'atasan') {
        return redirect()->back();
    }

    $bidangId = session()->get('bidang_id');
    $bidang   = $this->bidangModel->find($bidangId);

    if (!$bidang) {
        return redirect()->back();
    }

    // =========================
    // AMBIL DATA
    // =========================
    if ($bidang['parent_id'] === null) {
        // KAJUR
        $dokumen = $this->dokumenModel
            ->where('status', 'archived')
            ->where('unit_jurusan_id', $bidangId)
            ->orderBy('updated_at', 'DESC')
            ->findAll();
    } else {
        // KAPRODI
        $dokumen = $this->dokumenModel
            ->where('status', 'archived')
            ->where('unit_jurusan_id', $bidang['parent_id'])
            ->where('unit_asal_id', $bidangId)
            ->orderBy('updated_at', 'DESC')
            ->findAll();
    }

    // =========================
    // BUAT EXCEL
    // =========================
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Arsip Dokumen');

    // JUDUL
    $sheet->mergeCells('A1:D1');
    $sheet->setCellValue('A1', 'ARSIP DOKUMEN KINERJA');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A1')->getAlignment()
          ->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // HEADER
    $headerRow = 3;
    $headers = ['Judul Dokumen', 'Unit Asal', 'Tanggal Selesai', 'Status'];

    foreach ($headers as $i => $text) {
        $col = Coordinate::stringFromColumnIndex($i + 1);
        $sheet->setCellValue($col . $headerRow, $text);
    }

    $sheet->getStyle("A{$headerRow}:D{$headerRow}")->applyFromArray([
        'font' => [
            'bold' => true,
            'color' => ['rgb' => 'FFFFFF']
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER
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

    foreach ($dokumen as $d) {
        $sheet->setCellValue("A{$row}", $d['judul']);
        $sheet->setCellValue("B{$row}", 'Unit ' . $d['unit_asal_id']);
        $sheet->setCellValue(
            "C{$row}",
            date('d/m/Y', strtotime($d['updated_at']))
        );
        $sheet->setCellValue("D{$row}", 'VERIFIED');

        $sheet->getStyle("A{$row}:D{$row}")
              ->getBorders()
              ->getAllBorders()
              ->setBorderStyle(Border::BORDER_THIN);

        $sheet->getStyle("C{$row}:D{$row}")
              ->getAlignment()
              ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $row++;
    }

    // AUTO WIDTH
    foreach (range('A', 'D') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // LOG
    log_activity(
        'EXPORT_ARSIP_DOKUMEN_EXCEL',
        'Mengunduh arsip dokumen kinerja dalam format Excel',
        'dokumen_arsip',
        null
    );

    // DOWNLOAD
    $filename = 'arsip_dokumen_atasan_' . date('Ymd_His') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}


}
