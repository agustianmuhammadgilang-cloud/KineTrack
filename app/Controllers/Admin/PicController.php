<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PicModel;
use App\Models\TahunAnggaranModel;
use App\Models\SasaranModel;
use App\Models\IndikatorModel;
use App\Models\UserModel;
use App\Models\NotificationModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;


// Controller untuk mengelola PIC indikator kinerja
class PicController extends BaseController
{
    protected $picModel;
    protected $userModel;
    protected $notifModel;

    public function __construct()
    {
        $this->picModel = new PicModel();
        $this->userModel = new UserModel();
        $this->notifModel = new NotificationModel();
    }
// Menampilkan daftar PIC indikator
public function index()
{
    $keyword = $this->request->getGet('q');

    $builder = $this->picModel
        ->select('
            pic_indikator.id,
            indikator_kinerja.nama_indikator,
            users.nama AS nama_pic,
            jabatan.nama_jabatan,
            bidang.nama_bidang,
            tahun_anggaran.tahun
        ')
        ->join('users', 'users.id = pic_indikator.user_id')
        ->join('jabatan', 'jabatan.id = pic_indikator.jabatan_id', 'left')
        ->join('bidang', 'bidang.id = pic_indikator.bidang_id', 'left')
        ->join('indikator_kinerja', 'indikator_kinerja.id = pic_indikator.indikator_id')
        ->join('tahun_anggaran', 'tahun_anggaran.id = pic_indikator.tahun_id');

    // 🔍 SEARCH
    if (!empty($keyword)) {
        $builder->groupStart()
            ->like('users.nama', $keyword)
            ->orLike('indikator_kinerja.nama_indikator', $keyword)
            ->orLike('jabatan.nama_jabatan', $keyword)
            ->orLike('bidang.nama_bidang', $keyword)
            ->orLike('tahun_anggaran.tahun', $keyword)
        ->groupEnd();
    }

    $data['pic_list'] = $builder
        ->orderBy('pic_indikator.id', 'ASC')
        ->findAll();

    $data['keyword'] = $keyword;

    return view('admin/pic/index', $data);
}


// Menampilkan form untuk menambahkan PIC baru
    public function create()
    {
        $data['tahun'] = (new TahunAnggaranModel())
                    ->where('status', 'active')
                    ->findAll();

        return view('admin/pic/create', $data);
    }
// Menyimpan PIC baru
   public function store()
{
    $indikatorId = $this->request->getPost('indikator_id');
    $tahunId     = $this->request->getPost('tahun_id');
    $sasaranId   = $this->request->getPost('sasaran_id');
    $userList    = $this->request->getPost('pegawai') ?? []; 

    $successUsers = [];
    $skippedUsers = [];

    // Validasi minimal 1 PIC dipilih
    if (empty($userList)) {
        return redirect()->back()->with('alert', [
            'type'    => 'error',
            'title'   => 'Perhatian',
            'message' => 'PIC / user belum dipilih atau tidak ada yang sesuai!'
        ]);
    }

    foreach ($userList as $userId) {
        $user = $this->userModel->find($userId);

        if (!$user) {
            // User tidak ditemukan → hentikan proses
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Perhatian',
                'message' => "PIC / user dengan ID $userId tidak ditemukan!"
            ]);
        }

        // CEK DUPLIKAT (Tanpa TW)
        $exists = $this->picModel
            ->where('user_id', $userId)
            ->where('indikator_id', $indikatorId)
            ->where('tahun_id', $tahunId)
            ->first();

        if ($exists) {
            $skippedUsers[] = $user['nama'];
            continue;
        }

        // SIMPAN PIC (Tanpa TW)
        $this->picModel->insert([
            'indikator_id' => $indikatorId,
            'user_id'      => $userId,
            'tahun_id'     => $tahunId,
            'sasaran_id'   => $sasaranId,
            'bidang_id'    => $user['bidang_id'],
            'jabatan_id'   => $user['jabatan_id'],
            'is_viewed_by_staff' => 0
        ]);

        $assignedUserIds[] = $userId; // PENTING
        // LOG AKTIVITAS ADMIN
        if (!empty($assignedUserIds)) {
    log_activity(
        'assign_pic',
        'Menetapkan PIC indikator kepada ' . count($assignedUserIds) . ' pegawai',
        'indikator',
        $indikatorId
    );
}



        // SIMPAN NOTIFIKASI KE STAFF
        $this->notifModel->insert([
            'user_id' => $userId,
            'message' => "Anda mendapatkan tugas baru untuk indikator tahun $tahunId.",
            'meta'    => json_encode([
                'indikator_id' => $indikatorId,
                'tahun_id'     => $tahunId,
                'sasaran_id'   => $sasaranId
            ]),
            'status'   => 'unread'
        ]);

        $successUsers[] = $user['nama'];
    }

    // ======================
    // SweetAlert untuk ADMIN
    // ======================
    $message = '';
    $type    = 'success';

    if (!empty($successUsers)) {
        $message .= 'PIC berhasil disimpan untuk: ' . implode(', ', $successUsers) . '. ';
    }

    if (!empty($skippedUsers)) {
        $message .= 'PIC sudah terdaftar untuk: ' . implode(', ', $skippedUsers) . '.';
        $type = 'warning';
    }

    return redirect()->to('/admin/pic')->with('alert', [
        'type'    => $type,
        'title'   => $type === 'success' ? 'Berhasil' : 'Perhatian',
        'message' => $message
    ]);
}

    // ====================== AJAX ======================

    public function getSasaran()
    {
        $tahunId = $this->request->getGet('tahun_id');
        $sasaran = (new SasaranModel())
            ->where('tahun_id', $tahunId)
            ->findAll();

        return $this->response->setJSON($sasaran);
    }

    public function getIndikator()
    {
        $sasaranId = $this->request->getGet('sasaran_id');
        $indikator = (new IndikatorModel())
            ->where('sasaran_id', $sasaranId)
            ->findAll();

        return $this->response->setJSON($indikator);
    }

    public function getPegawai()
    {
        return $this->response->setJSON(
            $this->userModel
                ->select('users.*, jabatan.nama_jabatan, bidang.nama_bidang')
                ->join('jabatan', 'jabatan.id = users.jabatan_id', 'left')
                ->join('bidang', 'bidang.id = users.bidang_id', 'left')
                ->where('users.role !=', 'admin') // hanya staff dan atasan
                ->findAll()
        );
    }

// ====================== EXPORT PDF ======================
public function exportPdf()
{
    if (session()->get('role') !== 'admin') {
        return redirect()->back();
    }

    $pic_list = $this->picModel
        ->select('
            pic_indikator.id,
            indikator_kinerja.nama_indikator,
            users.nama AS nama_pic,
            jabatan.nama_jabatan,
            bidang.nama_bidang,
            tahun_anggaran.tahun
        ')
        ->join('users', 'users.id = pic_indikator.user_id')
        ->join('jabatan', 'jabatan.id = pic_indikator.jabatan_id', 'left')
        ->join('bidang', 'bidang.id = pic_indikator.bidang_id', 'left')
        ->join('indikator_kinerja', 'indikator_kinerja.id = pic_indikator.indikator_id')
        ->join('tahun_anggaran', 'tahun_anggaran.id = pic_indikator.tahun_id')
        ->orderBy('pic_indikator.id', 'ASC')
        ->findAll();

    $html = view('admin/pic/export_pdf', [
        'pic_list' => $pic_list
    ]);

    $options = new Options();
    $options->set('defaultFont', 'Helvetica');
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    log_activity(
    'EXPORT_PIC_PDF',
    'Admin mengekspor laporan PIC indikator kinerja lintas unit dan jabatan ke dalam file PDF.',
    'pic_indikator'
);


    $dompdf->stream('Laporan_PIC_' . date('Ymd_His') . '.pdf', ['Attachment' => true]);
}

public function exportExcel()
{
    if (session()->get('role') !== 'admin') {
        return redirect()->back();
    }

    // ======================
    // AMBIL DATA (SAMA PERSIS DENGAN PDF)
    // ======================
    $pic_list = $this->picModel
        ->select('
            pic_indikator.id,
            indikator_kinerja.nama_indikator,
            users.nama AS nama_pic,
            jabatan.nama_jabatan,
            bidang.nama_bidang,
            tahun_anggaran.tahun
        ')
        ->join('users', 'users.id = pic_indikator.user_id')
        ->join('jabatan', 'jabatan.id = pic_indikator.jabatan_id', 'left')
        ->join('bidang', 'bidang.id = pic_indikator.bidang_id', 'left')
        ->join('indikator_kinerja', 'indikator_kinerja.id = pic_indikator.indikator_id')
        ->join('tahun_anggaran', 'tahun_anggaran.id = pic_indikator.tahun_id')
        ->orderBy('pic_indikator.id', 'ASC')
        ->findAll();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Manajemen PIC');

    // ======================
    // JUDUL
    // ======================
    $sheet->mergeCells('A1:D1');
    $sheet->setCellValue('A1', 'LAPORAN MANAJEMEN PIC');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // ======================
    // HEADER TABEL
    // ======================
    $headerRow = 3;

    $headers = [
        'A' => 'Informasi Indikator',
        'B' => 'Penanggung Jawab (PIC)',
        'C' => 'Bidang / Jabatan',
        'D' => 'Tahun'
    ];

    foreach ($headers as $col => $text) {
        $sheet->setCellValue($col . $headerRow, $text);
    }

    $sheet->getStyle("A{$headerRow}:D{$headerRow}")->applyFromArray([
        'font' => [
            'bold' => true,
            'color' => ['rgb' => 'FFFFFF']
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical'   => Alignment::VERTICAL_CENTER
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

    // ======================
    // ISI DATA
    // ======================
    $row = $headerRow + 1;

    foreach ($pic_list as $p) {

        $sheet->setCellValue("A{$row}", $p['nama_indikator']);
        $sheet->setCellValue("B{$row}", $p['nama_pic']);
        $sheet->setCellValue(
            "C{$row}",
            $p['nama_bidang'] . ' / ' . $p['nama_jabatan']
        );
        $sheet->setCellValue("D{$row}", $p['tahun']);

        $sheet->getStyle("A{$row}:D{$row}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $row++;
    }

    // ======================
    // AUTO WIDTH
    // ======================
    foreach (range('A', 'D') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // ======================
    // LOG AKTIVITAS
    // ======================
    log_activity(
        'EXPORT_PIC_EXCEL',
        'Admin mengekspor laporan PIC indikator kinerja dalam format Excel.',
        'pic_indikator'
    );

    // ======================
    // DOWNLOAD
    // ======================
    $filename = 'Laporan_PIC_' . date('Ymd_His') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}

}