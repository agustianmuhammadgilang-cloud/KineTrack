<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\DokumenModel;
use App\Models\BidangModel;
use App\Models\KategoriDokumenModel;
use App\Models\NotificationModel;
use Dompdf\Dompdf;

// Controller untuk mengelola dokumen kinerja staff
class Dokumen extends BaseController
{
    protected $dokumenModel;
    protected $bidangModel;
    protected $kategoriModel;
    protected $notifModel;

    // Konstruktor untuk inisialisasi model dokumen, bidang, dan kategori
    public function __construct()
    {
        $this->dokumenModel  = new DokumenModel();
        $this->bidangModel   = new BidangModel();
        $this->kategoriModel = new KategoriDokumenModel();
        $this->notifModel    = new NotificationModel();
    }

    /**
     * ============================
     * LIST DOKUMEN MILIK STAFF
     * ============================
     */
    public function index()
    {
        // Ambil dokumen milik staff yang sedang login
        $userId = session()->get('user_id');
        // Cek jika user tidak login
        if (!$userId) {
            return redirect()->to('/login');
        }
        // Ambil dokumen
        $data['dokumen'] = $this->dokumenModel
            ->where('created_by', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
            // LOG AKTIVITAS STAFF Dokumen
            log_activity(
    'view_dokumen_list',
    'Melihat daftar dokumen kinerja pribadi'
);


        return view('staff/dokumen/index', $data);
    }

    /**
     * ============================
     * FORM UPLOAD DOKUMEN
     * ============================
     */
public function create()
{
    // LOG AKTIVITAS STAFF Dokumen
    log_activity(
    'open_upload_dokumen_form',
    'Membuka form upload dokumen kinerja'
);

    return view('staff/dokumen/create', [
        'kategori' => $this->kategoriModel->getUntukFormStaff()
    ]);
}



    /**
     * ============================
     * SIMPAN DOKUMEN
     * ============================
     */
    public function store()
{
    $userId     = session()->get('user_id');
    $bidangId   = session()->get('bidang_id');
    $kategoriId = $this->request->getPost('kategori_id');

    if (!$userId || !$bidangId) {
        return redirect()->to('/login');
    }

    // Validasi kategori
    if (!$kategoriId) {
        return redirect()->back()->with('error', 'Kategori wajib dipilih');
    }
    // Validasi file
    $file = $this->request->getFile('file');
    if (!$file || !$file->isValid()) {
        return redirect()->back()->with('error', 'File tidak valid');
    }
    // Tentukan alur berdasarkan unit kerja
    $bidangUser = $this->bidangModel->find($bidangId);
    // Jika unit kerja adalah prodi
    if ($bidangUser['parent_id'] !== null) {
        $unitAsal    = $bidangUser['id'];
        $unitJurusan = $bidangUser['parent_id'];
        $status      = 'pending_kaprodi';
        $reviewer    = 'kaprodi';
        // Jika unit kerja adalah jurusan
    } else {
        $unitAsal    = $bidangUser['id'];
        $unitJurusan = $bidangUser['id'];
        $status      = 'pending_kajur';
        $reviewer    = 'kajur';
    }
    // Upload file
    $newName = $file->getRandomName();
    $file->move('uploads/dokumen', $newName);
    $scopeInput = $this->request->getPost('scope');

    $scope = in_array($scopeInput, ['personal', 'unit', 'public'])
    ? $scopeInput
    : 'unit';



    // Simpan data dokumen
    $dokumenId = $this->dokumenModel->insert([
    'judul'            => $this->request->getPost('judul'),
    'deskripsi'        => $this->request->getPost('deskripsi'),
    'kategori_id'      => $kategoriId,
    'scope'            => $scope,
    'file_path'        => $newName,
    'created_by'       => $userId,
    'unit_asal_id'     => $unitAsal,
    'unit_jurusan_id'  => $unitJurusan,
    'status'           => $status,
    'current_reviewer' => $reviewer,
]);

// Ambil nama kategori untuk log
$kategori = $this->kategoriModel->find($kategoriId);
// LOG AKTIVITAS STAFF Dokumen
log_activity(
    'upload_dokumen',
    'Mengunggah dokumen "' . $this->request->getPost('judul') .
    '" kategori ' . ($kategori['nama_kategori'] ?? '-') .
    ' dengan scope ' . $scope,
    'dokumen',
    $dokumenId
);

$this->notifModel->insert([
    'user_id' => $userId,
    'message' => 'Dokumen "' . $this->request->getPost('judul') . '" berhasil dikirim dan menunggu persetujuan.',
    'meta'    => json_encode([
        'dokumen_id' => $dokumenId,
        'type'       => 'dokumen'
    ]),
    'status'  => 'unread',
    'created_at' => date('Y-m-d H:i:s')
]);

// ===============================
// Kirim Notif Ke Atasan sesuai scope
$viewsModel = model('DokumenViewModel');

if ($reviewer === 'kaprodi') {
    // cari KETUA PRODI
    $atasanList = model('UserModel')
        ->where('role', 'atasan')
        ->where('bidang_id', $unitAsal) // PRODI
        ->findAll();

    $pesan = 'Dokumen baru "' . $this->request->getPost('judul') . '" menunggu persetujuan Ketua Prodi.';
} else {
    // cari KETUA JURUSAN
    $atasanList = model('UserModel')
        ->where('role', 'atasan')
        ->where('bidang_id', $unitJurusan) // JURUSAN
        ->findAll();

    $pesan = 'Dokumen baru "' . $this->request->getPost('judul') . '" menunggu persetujuan Ketua Jurusan.';
}

// Reset view state agar badge muncul
foreach ($atasanList as $atasan) {
    $viewsModel->where([
        'dokumen_id' => $dokumenId,
        'user_id'    => $atasan['id']
    ])->delete();

    // Kirim notif ke atasan
    $this->notifModel->insert([
        'user_id' => $atasan['id'],
        'message' => $pesan,
        'meta'    => json_encode([
            'dokumen_id' => $dokumenId,
            'type'       => 'upload'
        ]),
        'status'     => 'unread',
        'created_at' => date('Y-m-d H:i:s')
    ]);
}

// ===============================
if ($reviewer === 'kaprodi') {
    // cari KETUA PRODI
    $atasanList = model('UserModel')
        ->where('role', 'atasan')
        ->where('bidang_id', $unitAsal) // PRODI
        ->findAll();

    $pesan = 'Dokumen baru "' . $this->request->getPost('judul') . '" menunggu persetujuan Ketua Prodi.';
} else {
    // cari KETUA JURUSAN
    $atasanList = model('UserModel')
        ->where('role', 'atasan')
        ->where('bidang_id', $unitJurusan) // JURUSAN
        ->findAll();

    $pesan = 'Dokumen baru "' . $this->request->getPost('judul') . '" menunggu persetujuan Ketua Jurusan.';
}

foreach ($atasanList as $atasan) {
    $this->notifModel->insert([
        'user_id' => $atasan['id'],
        'message' => $pesan,
        'meta'    => json_encode([
            'dokumen_id' => $dokumenId,
            'type'       => 'upload'
        ]),
        'status'     => 'unread',
        'created_at' => date('Y-m-d H:i:s')
    ]);
}


    foreach ($atasanList as $atasan) {
        $this->notifModel->insert([
            'user_id' => $atasan['id'],
            'message' => 'Dokumen baru "' . $this->request->getPost('judul') . '" telah diajukan dan menunggu persetujuan Anda.',
            'meta'    => json_encode([
                'dokumen_id' => $dokumenId,
                'type'       => 'upload'
            ]),
            'status'  => 'unread',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }


    return redirect()->to('/staff/dokumen')
        ->with('success', 'Dokumen berhasil dikirim');
}


    /**
     * ============================
     * FORM REVISI DOKUMEN
     * ============================
     */
    public function resubmit($id)
    {
        // Ambil dokumen milik user yang berstatus ditolak
        $userId = session()->get('user_id');
        // Cek jika user tidak login
        $dokumen = $this->dokumenModel
            ->where('id', $id)
            ->where('created_by', $userId)
            ->whereIn('status', ['rejected_kaprodi', 'rejected_kajur'])
            ->first();
        // Cek jika dokumen tidak ditemukan atau tidak boleh direvisi
        if (!$dokumen) {
            return redirect()->back()->with('error', 'Dokumen tidak dapat direvisi');
        }
        // LOG AKTIVITAS STAFF Dokumen
        log_activity(
    'open_resubmit_dokumen_form',
    'Membuka form revisi dokumen "' . $dokumen['judul'] . '"',
    'dokumen',
    $dokumen['id']
);


        return view('staff/dokumen/resubmit', [
            'dokumen'  => $dokumen,
            'kategori' => $this->kategoriModel->getAktif()
        ]);
    }

    /**
     * ============================
     * PROSES REVISI
     * ============================
     */
    public function processResubmit($id)
    {
        // Ambil dokumen milik user yang berstatus ditolak
        $userId   = session()->get('user_id');
        $bidangId = session()->get('bidang_id');
        // Cek jika user tidak login
        $dokumen = $this->dokumenModel
            ->where('id', $id)
            ->where('created_by', $userId)
            ->first();
        // Cek jika dokumen tidak ditemukan atau tidak boleh direvisi
        if (!$dokumen) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan');
        }
        // Validasi file
        $file = $this->request->getFile('file');
        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid');
        }
        // Tentukan alur berdasarkan unit kerja
        $bidangUser = $this->bidangModel->find($bidangId);

        // Jika unit kerja adalah prodi
        if ($bidangUser['parent_id'] !== null) {
            $status   = 'pending_kaprodi';
            $reviewer = 'kaprodi';
            // Jika unit kerja adalah jurusan
        } else {
            $status   = 'pending_kajur';
            $reviewer = 'kajur';
        }

        // Upload file baru
        $newName = $file->getRandomName();
        $file->move('uploads/dokumen', $newName);

        $this->dokumenModel->update($id, [
    'judul'            => $this->request->getPost('judul'),
    'deskripsi'        => $this->request->getPost('deskripsi'),
    'file_path'        => $newName,
    'status'           => $status,
    'current_reviewer' => $reviewer,
    'catatan'          => null,
    'updated_at'       => date('Y-m-d H:i:s'),
]);

        // LOG AKTIVITAS STAFF Dokumen
        log_activity(
    'resubmit_dokumen',
    'Mengirim revisi dokumen "' . $dokumen['judul'] . '"',
    'dokumen',
    $id
);

$this->notifModel->insert([
    'user_id' => $userId,
    'message' => 'Revisi dokumen "' . $dokumen['judul'] . '" berhasil dikirim ulang.',
    'meta'    => json_encode([
        'dokumen_id' => $id,
        'type'       => 'dokumen'
    ]),
    'status'  => 'unread',
    'created_at' => date('Y-m-d H:i:s')
]);

 // ===============================
    // NOTIF KE ATASAN (REVISI)
    // ===============================
if ($reviewer === 'kaprodi') {
    $atasanList = model('UserModel')
        ->where('role', 'atasan')
        ->where('bidang_id', $bidangUser['id']) // PRODI
        ->findAll();

    $pesan = 'Revisi dokumen "' . $dokumen['judul'] . '" menunggu peninjauan Ketua Prodi.';
} else {
    $atasanList = model('UserModel')
        ->where('role', 'atasan')
        ->where('bidang_id', $bidangUser['id']) // JURUSAN
        ->findAll();

    $pesan = 'Revisi dokumen "' . $dokumen['judul'] . '" menunggu peninjauan Ketua Jurusan.';
}

foreach ($atasanList as $atasan) {
    $this->notifModel->insert([
        'user_id' => $atasan['id'],
        'message' => $pesan,
        'meta'    => json_encode([
            'dokumen_id' => $id,
            'type'       => 'resubmit'
        ]),
        'status'     => 'unread',
        'created_at' => date('Y-m-d H:i:s')
    ]);

    
        $this->notifModel->insert([
            'user_id' => $atasan['id'],
            'message' => 'Revisi dokumen "' . $dokumen['judul'] . '" telah diajukan dan menunggu peninjauan ulang.',
            'meta'    => json_encode([
                'dokumen_id' => $id,
                'type'       => 'resubmit'
            ]),
            'status'  => 'unread',
            'created_at' => date('Y-m-d H:i:s')
        ]);
}


        return redirect()->to('/staff/dokumen')
            ->with('success', 'Dokumen berhasil dikirim ulang');
    }

    /**
     * ============================
     * ARSIP
     * ============================
     */
    public function arsip()
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        $data['dokumen'] = $this->dokumenModel
            ->where('created_by', $userId)
            ->where('status', 'archived')
            ->orderBy('updated_at', 'DESC')
            ->findAll();
            // LOG AKTIVITAS STAFF Dokumen
            log_activity(
    'view_dokumen_arsip',
    'Melihat arsip dokumen kinerja'
);


        return view('staff/dokumen/arsip', $data);
    }
    /**
 * ============================
 * DOKUMEN PERSONAL (DOKUMEN SAYA)
 * ============================
 */
public function personal()
{
    // Ambil dokumen personal milik staff yang sedang login
    $userId = session()->get('user_id');
    // Cek jika user tidak login
    if (!$userId) {
        return redirect()->to('/login');
    }
    // Ambil dokumen
    $data['dokumen'] = $this->dokumenModel
        ->where('created_by', $userId)
        ->where('scope', 'personal') // asumsi dari pilihan saat create
        ->orderBy('created_at', 'DESC')
        ->findAll();

    return view('staff/dokumen/personal', $data);
}

/**
 * ============================
 * DOKUMEN UNIT
 * ============================
 */
public function unit()
{
    // Ambil dokumen unit kerja milik staff yang sedang login
    $userId   = session()->get('user_id');
    $bidangId = session()->get('bidang_id');
    // Cek jika user tidak login
    if (!$userId || !$bidangId) {
        return redirect()->to('/login');
    }
    // Tentukan alur berdasarkan unit kerja
    $bidangUser = $this->bidangModel->find($bidangId);

    // Jika unit kerja adalah prodi
    $unitJurusan = $bidangUser['parent_id'] ?? $bidangUser['id'];

    // Ambil dokumen
    $data['dokumen'] = $this->dokumenModel->getDokumenUnit($unitJurusan);
    // LOG AKTIVITAS STAFF Dokumen
    log_activity(
    'view_dokumen_unit',
    'Melihat dokumen unit kerja'
);

    return view('staff/dokumen/unit', $data);
}

// ============================
// DOKUMEN PUBLIC
// ============================
public function public()
{
    // Cek jika user tidak login
    if (!session()->get('user_id')) {
        return redirect()->to('/login');
    }
    // Ambil dokumen publik
    $data['dokumen'] = $this->dokumenModel->getDokumenPublic();
    // LOG AKTIVITAS STAFF Dokumen
    log_activity(
    'view_dokumen_public',
    'Melihat dokumen publik'
);

    return view('staff/dokumen/public', $data);
}

public function exportArsipPdf()
{
    $userId = session()->get('user_id');
    if (!$userId) {
        return redirect()->to('/login');
    }

    $dokumen = $this->dokumenModel->getArsipDenganKategori($userId);

    $html = view('staff/dokumen/export_pdf', [
        'dokumen' => $dokumen
    ]);

    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $filename = 'arsip_dokumen_' . date('Ymd_His') . '.pdf';
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
    return $dompdf->stream($filename, ['Attachment' => true]);
}



}
