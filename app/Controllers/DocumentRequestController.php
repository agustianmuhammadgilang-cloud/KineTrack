<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DocumentRequestModel;
use App\Models\DocumentAccessModel;
use App\Models\DokumenModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class DocumentRequestController extends BaseController
{
    protected $requestModel;
    protected $accessModel;
    protected $documentModel;

    public function __construct()
    {
        $this->requestModel  = new DocumentRequestModel();
        $this->accessModel   = new DocumentAccessModel();
        $this->documentModel = new DokumenModel();
    }

    /**
     * =====================================================
     * 1️⃣ HALAMAN UTAMA
     * List judul dokumen private / unit (SEMUA ROLE)
     * =====================================================
     */
    public function index()
{
    $userId = session('user_id');
    $role   = session('role'); // 'staff' | 'atasan'

    // ======================
    // 🔍 SEARCH KEYWORD
    // ======================
    $search = trim($this->request->getGet('search'));

    // ======================
    // STATUS REQUEST USER
    // ======================
    $requestMap = $this->requestModel
        ->select('document_id, status')
        ->where('requester_id', $userId)
        ->whereIn('status', ['pending', 'approved'])
        ->findAll();

    $requestStatus = [];
    foreach ($requestMap as $r) {
        $requestStatus[$r['document_id']] = $r['status'];
    }

    // ======================
    // QUERY DOKUMEN
    // ======================
    $query = $this->documentModel
        ->select([
            'dokumen_kinerja.id',
            'dokumen_kinerja.judul',
            'dokumen_kinerja.created_at',
            'dokumen_kinerja.created_by',
            'users.nama AS nama_pemilik',
            'COALESCE(unit_asal.nama_bidang, unit_jurusan.nama_bidang) AS nama_unit'
        ])
        ->join('users', 'users.id = dokumen_kinerja.created_by')
        ->join('bidang AS unit_asal', 'unit_asal.id = dokumen_kinerja.unit_asal_id', 'left')
        ->join('bidang AS unit_jurusan', 'unit_jurusan.id = dokumen_kinerja.unit_jurusan_id', 'left')
        ->where('dokumen_kinerja.status', 'archived')
        ->whereIn('dokumen_kinerja.scope', ['personal', 'unit']);

    // ======================
    // 🔥 SEARCH LOGIC (AMAN)
    // ======================
    if (!empty($search)) {
        $query->groupStart()
            ->like('dokumen_kinerja.judul', $search)
            ->orLike('users.nama', $search)
            ->orLike('unit_asal.nama_bidang', $search)
            ->orLike('unit_jurusan.nama_bidang', $search)
        ->groupEnd();
    }

    // ======================
    // BADGE
    // ======================
    $badgeIncoming = 0;
    if ($role === 'staff') {
        $badgeIncoming = $this->requestModel
            ->where('owner_id', $userId)
            ->where('status', 'pending')
            ->countAllResults();
    }

    $badgeStatus = $this->requestModel->countUnseenStatus($userId);

    // ======================
    // PILIH VIEW SESUAI ROLE
    // ======================
    $viewPath = ($role === 'atasan')
        ? 'atasan/document_request/index'
        : 'staff/document_request/index';

    return view($viewPath, [
        'documents'     => $query->findAll(),
        'badgeIncoming' => $badgeIncoming,
        'badgeStatus'   => $badgeStatus,
        'requestStatus' => $requestStatus,
        'search'        => $search, // optional buat value input
    ]);
}




public function viewAttachment($filename)
{
    $path = WRITEPATH . 'uploads/request/' . $filename;

    if (!file_exists($path)) {
        throw PageNotFoundException::forPageNotFound("File tidak ditemukan!");
    }

    $file = new \CodeIgniter\Files\File($path);
    $mimeType = $file->getMimeType();


    // 8️⃣ LOG AKTIVITAS
        log_activity(
    'view_attachment',
    'Melihat lampiran permintaan dokumen',
    'attachment',
    null
);
    // Kirim file ke browser
    return $this->response
        ->setHeader('Content-Type', $mimeType)
        ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
        ->setBody(file_get_contents($path));


}



    /**
     * =====================================================
     * 2️⃣ FORM PERMINTAAN DOKUMEN
     * (SEMUA ROLE BOLEH REQUEST)
     * =====================================================
     */
    public function create($documentId)
    {
        $document = $this->documentModel->find($documentId);

        if (!$document) {
            throw new PageNotFoundException();
        }

        return view('staff/document_request/form', [
            'document' => $document,
        ]);
    }

    /**
     * =====================================================
     * 3️⃣ SIMPAN PERMINTAAN
     * =====================================================
     */
    public function store()
{
    $documentId = $this->request->getPost('document_id');
    $ownerId    = $this->request->getPost('owner_id');
    $userId     = session('user_id');

    // 1️⃣ Validasi: tidak boleh request dokumen milik sendiri
    if ($ownerId == $userId) {
        return redirect()->back()
            ->with('error', 'Anda tidak dapat mengajukan akses ke dokumen milik sendiri.');
    }

    // 2️⃣ Validasi: cek request pending yang sama
    $existingRequest = $this->requestModel
        ->where('document_id', $documentId)
        ->where('requester_id', $userId)
        ->where('owner_id', $ownerId)
        ->where('status', 'pending')
        ->first();

    if ($existingRequest) {
        return redirect()->back()
            ->with('error', 'Permintaan akses untuk dokumen ini masih menunggu persetujuan.');
    }

    // 3️⃣ Upload attachment (jika ada)
    $attachmentName = null;
    $file = $this->request->getFile('attachment');

    if ($file && $file->isValid()) {
        $attachmentName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads/request', $attachmentName);
    }

    

    // 4️⃣ Insert request
    $requestId = $this->requestModel->insert([
        'document_id'  => $documentId,
        'requester_id' => $userId,
        'owner_id'     => $ownerId,
        'reason'       => $this->request->getPost('reason'),
        'attachment'   => $attachmentName,
        'status'       => 'pending',
    ]);
// 4️⃣ LOG AKTIVITAS
    log_activity(
    'request_document',
    'Mengajukan permintaan akses dokumen',
    'document',
    $documentId
);


    // 5️⃣ Notifikasi ke pemohon (Staff A)
    $this->sendNotification(
        $userId,
        'Permintaan dokumen berhasil dikirim.'
    );

    // 6️⃣ Notifikasi ke pemilik dokumen (Staff B)
    $this->sendNotification(
        $ownerId,
        'Ada permintaan dokumen baru dari ' . session('nama'),
        ['request_id' => $requestId]
    );

    return redirect()->to('/document-request')
        ->with('success', 'Permintaan dokumen berhasil dikirim.');
}


    /**
     * =====================================================
     * 4️⃣ INBOX PERMINTAAN
     * (HANYA STAFF PEMILIK DOKUMEN)
     * =====================================================
     */
    // app\Controllers\DocumentRequestController.php
public function inbox()
{
    // 3️⃣ LOG AKTIVITAS
    log_activity(
    'view_inbox',
    'Melihat inbox permintaan dokumen',
    'document_request',
    null
);

    $userId = session('user_id');

    // 🔔 tandai notif masuk sebagai read
    $notifModel = new \App\Models\NotificationModel();
    $notifModel
        ->where('user_id', $userId)
        ->where('status', 'unread')
        ->like('message', 'permintaan dokumen')
        ->set(['status' => 'read'])
        ->update();

    $requests = $this->requestModel
        ->select('document_requests.*, dokumen_kinerja.judul, users.nama as nama_pemohon')
        ->join('dokumen_kinerja', 'dokumen_kinerja.id = document_requests.document_id')
        ->join('users', 'users.id = document_requests.requester_id')
        ->where('document_requests.owner_id', $userId)
        ->orderBy('document_requests.created_at', 'DESC')
        ->findAll();

    // 🔴 BADGE
    $badgeIncoming = $this->requestModel
        ->where('owner_id', $userId)
        ->where('status', 'pending')
        ->countAllResults();

    $badgeStatus = $this->requestModel->countUnseenStatus($userId);


    return view('staff/document_request/incoming', [
        'requests'       => $requests,
        'badgeIncoming'  => $badgeIncoming,
        'badgeStatus'    => $badgeStatus,
        'activeTab'      => 'incoming'
    ]);
}



    /**
     * =====================================================
     * 5️⃣ SETUJUI PERMINTAAN
     * (HANYA PEMILIK DOKUMEN)
     * =====================================================
     */
    /**
     * 5️⃣ SETUJUI PERMINTAAN
     */
    public function approve($requestId)
    {
        // Ganti pengecekan ketat ini agar tidak langsung 404
        // Kita cek apakah user memang punya otoritas atau sedang login
        if (!session('user_id')) {
            return redirect()->to('/login');
        }

        $request = $this->requestModel->find($requestId);

        // Pastikan request ada DAN yang menyetujui adalah pemilik dokumennya
        if (!$request || $request['owner_id'] != session('user_id')) {
            return redirect()->back()->with('error', 'Akses tidak valid atau data tidak ditemukan.');
        }

        // update status ke database
        $this->requestModel->updateStatus($requestId, 'approved');

        // berikan akses dokumen ke tabel document_access
        $this->accessModel->grantAccess(
            $request['document_id'],
            $request['requester_id'],
            session('user_id')
        );
// 6️⃣ LOG AKTIVITAS
        log_activity(
    'approve_request',
    'Menyetujui permintaan akses dokumen',
    'document_request',
    $requestId
);


        // Setelah update status dan grant akses
        $this->sendNotification(session('user_id'), "Anda berhasil menyetujui permintaan dokumen.");

        $this->sendNotification(
            $request['requester_id'],
            "Permintaan dokumen Anda telah disetujui oleh " . session('nama'),
            ['request_id' => $requestId, 'status' => 'approved']
        );


        return redirect()->back()->with('success', 'Permintaan akses dokumen berhasil disetujui.');
    }

    /**
     * 6️⃣ TOLAK PERMINTAAN
     */
    public function reject($requestId)
    {
        if (!session('user_id')) {
            return redirect()->to('/login');
        }

        $note = $this->request->getPost('note');

        if (!$note) {
            return redirect()->back()->with('error', 'Catatan penolakan wajib diisi.');
        }

        $request = $this->requestModel->find($requestId);

        if (!$request || $request['owner_id'] != session('user_id')) {
            return redirect()->back()->with('error', 'Akses tidak valid.');
        }

        $this->requestModel->updateStatus($requestId, 'rejected', $note);
// 7️⃣ LOG AKTIVITAS
        log_activity(
    'reject_request',
    'Menolak permintaan akses dokumen',
    'document_request',
    $requestId
);


        $this->sendNotification(session('user_id'), "Anda berhasil menolak permintaan dokumen.");

    $this->sendNotification(
        $request['requester_id'],
        "Permintaan dokumen Anda ditolak oleh " . session('nama') . ". Catatan: " . $note,
        ['request_id' => $requestId, 'status' => 'rejected']
    );


        return redirect()->back()->with('success', 'Permintaan akses dokumen telah ditolak.');
    }

    /**
     * =====================================================
     * 7️⃣ STATUS PERMINTAAN USER
     * (SEMUA ROLE)
     * =====================================================
     */
   
// app\Controllers\DocumentRequestController.php

public function status()
{
// 8️⃣ LOG AKTIVITAS
log_activity(
    'view_request_status',
    'Melihat status permintaan dokumen',
    'document_request',
    null
);

    $userId = session('user_id');
    $role   = session('role'); // 'staff' | 'atasan'

    // 🔔 tandai notif status sebagai read
    $notifModel = new \App\Models\NotificationModel();
    $notifModel
        ->where('user_id', $userId)
        ->where('status', 'unread')
        ->groupStart()
            ->like('message', 'disetujui')
            ->orLike('message', 'ditolak')
        ->groupEnd()
        ->set(['status' => 'read'])
        ->update();

    // 🔥 reset badge status
    $this->requestModel->markSeenByRequester($userId);

    // 📄 data request (alur lama)
    $requests = $this->requestModel
        ->select('document_requests.*, dokumen_kinerja.judul, dokumen_kinerja.file_path, users.nama as nama_pemilik')
        ->join('dokumen_kinerja', 'dokumen_kinerja.id = document_requests.document_id')
        ->join('users', 'users.id = document_requests.owner_id')
        ->where('document_requests.requester_id', $userId)
        ->orderBy('document_requests.created_at', 'DESC')
        ->findAll();

    // 🔴 badge
    $badgeIncoming = ($role === 'staff')
        ? $this->requestModel
            ->where('owner_id', $userId)
            ->where('status', 'pending')
            ->countAllResults()
        : 0;

    $badgeStatus = $this->requestModel->countUnseenStatus($userId);

    // 🔥 PILIH VIEW SESUAI ROLE
    $viewPath = ($role === 'atasan')
        ? 'atasan/document_request/status'
        : 'staff/document_request/status';

    return view($viewPath, [
        'requests'       => $requests,
        'badgeIncoming'  => $badgeIncoming,
        'badgeStatus'    => $badgeStatus,
        'activeTab'      => 'status'
    ]);
}




protected function sendNotification($userId, $message, $meta = null)
{
    $notifModel = new \App\Models\NotificationModel();
    $notifModel->insert([
        'user_id' => $userId,
        'message' => $message,
        'meta'    => $meta ? json_encode($meta) : null,
        'status'  => 'unread'
    ]);
}

}