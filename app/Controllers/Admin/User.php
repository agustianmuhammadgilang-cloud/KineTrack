<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\JabatanModel;
use App\Models\BidangModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Controller untuk mengelola user
class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }
// Menampilkan daftar user
public function index()
{
    $keyword = $this->request->getGet('q');

    $builder = $this->userModel
        ->select('users.*, jabatan.nama_jabatan, bidang.nama_bidang')
        ->join('jabatan', 'jabatan.id = users.jabatan_id', 'left')
        ->join('bidang', 'bidang.id = users.bidang_id', 'left');

    // 🔍 GLOBAL SEARCH
    if (!empty($keyword)) {
        $builder->groupStart()
            ->like('users.nama', $keyword)
            ->orLike('users.email', $keyword)
            ->orLike('jabatan.nama_jabatan', $keyword)
            ->orLike('bidang.nama_bidang', $keyword)
        ->groupEnd();
    }

    $data = [
        'users'   => $builder->findAll(),
        'keyword' => $keyword
    ];

    return view('admin/users/index', $data);
}


    public function exportPdf()
{
    if (session()->get('role') !== 'admin') {
        return redirect()->back();
    }

    $users = $this->userModel
        ->select('users.*, jabatan.nama_jabatan, bidang.nama_bidang')
        ->join('jabatan', 'jabatan.id = users.jabatan_id', 'left')
        ->join('bidang', 'bidang.id = users.bidang_id', 'left')
        ->orderBy('bidang.nama_bidang', 'ASC')
        ->findAll();

    // =========================
    // GROUP SESUAI TAMPILAN
    // =========================
    $groupedUsers = [];

    foreach ($users as $u) {
        $unit = $u['nama_bidang'] ?? 'Tanpa Unit';
        $groupedUsers[$unit][] = $u;
    }

    $html = view('admin/users/export_pdf', [
        'groupedUsers' => $groupedUsers
    ]);

    $options = new Options();
    $options->set('defaultFont', 'Helvetica');

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // ======================
// 🔥 LOG AKTIVITAS EXPORT USER
// ======================
log_activity(
    'EXPORT_USERS_PDF',
    'Mengunduh daftar pengguna dalam format PDF (' .
    count($users) . ' data, dikelompokkan per bidang).',
    'users'
);


    $dompdf->stream(
        'data_user_' . date('Ymd_His') . '.pdf',
        ['Attachment' => true]
    );
}

// Menampilkan form untuk menambahkan user baru
    public function create()
{
    $jabatanModel = new JabatanModel();

    $data['jabatan'] = $jabatanModel->findAll();

    // 🔥 Tambahan: jabatan default ADMIN (statis)
    $data['jabatan_admin'] = [
        'id' => 'admin',
        'nama_jabatan' => 'Administrator Sistem'
    ];

    $data['bidang']  = (new BidangModel())->findAll();
    return view('admin/users/create', $data);
}

// Menyimpan user baru
    public function store()
{
    $nama       = $this->request->getPost('nama');
    $email      = $this->request->getPost('email');
    $jabatan_id = $this->request->getPost('jabatan_id');
    $bidang_id  = $this->request->getPost('bidang_id');

    // =========================
    // CEK DUPLIKAT
    // =========================
    $existing = $this->userModel
        ->groupStart()
            ->where('nama', $nama)
            ->orWhere('email', $email)
        ->groupEnd()
        ->first();

    if ($existing) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Akun dengan nama atau email ini sudah terdaftar!');
    }

    // =========================
    // 🔥 KHUSUS ADMIN
    // =========================
    if ($jabatan_id === 'admin') {

        $userId = $this->userModel->insert([
            'nama'       => $nama,
            'email'      => $email,
            'jabatan_id' => null,
            'bidang_id'  => null,
            'role'       => 'admin',
            'password'   => password_hash('123456', PASSWORD_DEFAULT)
        ]);

        log_activity(
            'create_admin',
            'Menambahkan ADMIN baru: ' . $nama,
            'users',
            $userId
        );

        return redirect()->to('/admin/users')
            ->with('success', 'Admin berhasil ditambahkan. Password default: 123456');
    }

    // =========================
    // USER NON-ADMIN (LOGIKA LAMA)
    // =========================
    $jabatan = (new JabatanModel())->find($jabatan_id);

    if (!$jabatan || empty($jabatan['default_role'])) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Jabatan tidak valid atau belum memiliki role sistem.');
    }

    $userId = $this->userModel->insert([
        'nama'       => $nama,
        'email'      => $email,
        'jabatan_id' => $jabatan_id,
        'bidang_id'  => $bidang_id,
        'role'       => $jabatan['default_role'],
        'password'   => password_hash('123456', PASSWORD_DEFAULT)
    ]);

    log_activity(
        'create_user',
        'Menambahkan user baru: ' . $nama,
        'users',
        $userId
    );

    return redirect()->to('/admin/users')
        ->with('success', 'User berhasil ditambahkan. Password default: 123456');
}


// Menampilkan form untuk mengedit user
    public function edit($id)
    {
        $userModel   = $this->userModel;
        $jabatanModel = new JabatanModel();
        $bidangModel  = new BidangModel();

        $data['user']    = $userModel->find($id);
        $data['jabatan'] = $jabatanModel->findAll();
        $data['bidang']  = $bidangModel->findAll();

        return view('admin/users/edit', $data);
    }
// Memperbarui user
    public function update($id)
{
    $nama       = $this->request->getPost('nama');
    $email      = $this->request->getPost('email');
    $jabatan_id = $this->request->getPost('jabatan_id');
    $bidang_id  = $this->request->getPost('bidang_id');

    //  Cek duplikat kecuali diri sendiri
    $existing = $this->userModel
        ->where('id !=', $id)
        ->groupStart()
            ->where('nama', $nama)
            ->orWhere('email', $email)
        ->groupEnd()
        ->first();

    if ($existing) {
        return redirect()->back()->withInput()->with('error', 'Akun dengan nama atau email ini sudah terdaftar!');
    }

    // Ambil role dari jabatan
    $jabatan = (new JabatanModel())->find($jabatan_id);

    if (!$jabatan || empty($jabatan['default_role'])) {
        return redirect()->back()->withInput()->with('error', 'Jabatan tidak valid atau belum memiliki role sistem.');
    }

    //  Update user
    $this->userModel->update($id, [
        'nama'       => $nama,
        'email'      => $email,
        'jabatan_id' => $jabatan_id,
        'bidang_id'  => $bidang_id,
        'role'       => $jabatan['default_role'] // 🔥 AUTO
    ]);
// LOG AKTIVITAS
    log_activity(
    'update_user',
    'Mengubah data user: ' . $nama,
    'users',
    $id
);


    return redirect()->to('/admin/users')->with('success', 'User berhasil diupdate.');
}

// Menghapus user
    public function delete($id)
{
    $user = $this->userModel->find($id);

    if ($user) {
        $this->userModel->delete($id);

        log_activity(
            'delete_user',
            'Menghapus user: ' . $user['nama'],
            'users',
            $id
        );
    }

    return redirect()->to('/admin/users')
        ->with('success', 'User berhasil dihapus.');
}


    // Endpoint Ajax untuk cek duplicate
    public function checkDuplicate()
    {
        $data = $this->request->getJSON(true);

        $nama  = $data['nama'] ?? '';
        $email = $data['email'] ?? '';

        $exists = $this->userModel
            ->where('nama', $nama)
            ->orWhere('email', $email)
            ->first();

        return $this->response->setJSON(['exists' => $exists ? true : false]);
    }

    public function exportExcel()
{
    if (session()->get('role') !== 'admin') {
        return redirect()->back();
    }

    $users = $this->userModel
        ->select('users.*, jabatan.nama_jabatan, bidang.nama_bidang')
        ->join('jabatan', 'jabatan.id = users.jabatan_id', 'left')
        ->join('bidang', 'bidang.id = users.bidang_id', 'left')
        ->orderBy('bidang.nama_bidang', 'ASC')
        ->orderBy('users.nama', 'ASC')
        ->findAll();

    // =========================
    // GROUP PER BIDANG
    // =========================
    $groupedUsers = [];
    foreach ($users as $u) {
        $unit = $u['nama_bidang'] ?? 'Tanpa Unit Kerja';
        $groupedUsers[$unit][] = $u;
    }

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Data User');

    $row = 1;

    foreach ($groupedUsers as $unitName => $unitUsers) {

        // 🔹 Judul Unit
        $sheet->mergeCells("A{$row}:E{$row}");
        $sheet->setCellValue("A{$row}", strtoupper($unitName));
        $sheet->getStyle("A{$row}")->getFont()->setBold(true);
        $sheet->getStyle("A{$row}")->getFill()
            ->setFillType('solid')
            ->getStartColor()->setARGB('FFE5E7EB');
        $row++;

        // 🔹 Header Tabel
        $sheet->setCellValue("A{$row}", 'No');
        $sheet->setCellValue("B{$row}", 'Nama');
        $sheet->setCellValue("C{$row}", 'Email');
        $sheet->setCellValue("D{$row}", 'Jabatan');
        $sheet->setCellValue("E{$row}", 'Role');

        $sheet->getStyle("A{$row}:E{$row}")->getFont()->setBold(true);
        $row++;

        // 🔹 Data User
        $no = 1;
        foreach ($unitUsers as $u) {
            $sheet->setCellValue("A{$row}", $no++);
            $sheet->setCellValue("B{$row}", $u['nama']);
            $sheet->setCellValue("C{$row}", $u['email']);
            $sheet->setCellValue("D{$row}", $u['nama_jabatan']);
            $sheet->setCellValue("E{$row}", ucfirst($u['role']));
            $row++;
        }

        $row += 2; // spasi antar unit
    }

    // Auto width
    foreach (range('A', 'E') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // ======================
    // LOG AKTIVITAS
    // ======================
    log_activity(
        'EXPORT_USERS_EXCEL',
        'Mengunduh daftar pengguna dalam format Excel (' . count($users) . ' data, dikelompokkan per bidang).',
        'users'
    );

    // ======================
    // DOWNLOAD
    // ======================
    $filename = 'data_user_' . date('Ymd_His') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}

}
