<?php

namespace App\Controllers\Atasan;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\NotificationModel;
// Controller untuk mengelola profil atasan
class Profile extends BaseController
{
    // Menampilkan halaman profil atasan
    public function index()
    {
        $model = new UserModel();
        $data['user'] = $model->find(session('user_id'));
        // Catat aktivitas melihat profil
        log_activity(
    'view_profile',
    'Melihat halaman profil pribadi',
    'user',
    session('user_id')
);

        return view('atasan/profile', $data);
    }

    // Memperbarui data profil atasan
public function update()
{
    $userId    = session()->get('user_id');
    $userModel = new \App\Models\UserModel();

    $user = $userModel->find($userId);

    // =========================
    // DATA UTAMA
    // =========================
    $data = [
        'nama'  => $this->request->getPost('nama'),
        'email' => $this->request->getPost('email'),
    ];

    // =========================
    // FOTO PROFIL STAFF (BARU)
    // =========================
    $foto = $this->request->getFile('foto');

    if ($foto && $foto->isValid() && !$foto->hasMoved()) {

        // hapus foto lama jika ada
        if (!empty($user['foto']) && file_exists('uploads/profile/' . $user['foto'])) {
            unlink('uploads/profile/' . $user['foto']);
        }

        $fotoName = $foto->getRandomName();
        $foto->move('uploads/profile/', $fotoName);

        $data['foto'] = $fotoName;

        // update session foto
        session()->set('foto', $fotoName);
    }

    // =========================
    // TTD DIGITAL (EXISTING)
    // =========================
    $fileTtd = $this->request->getFile('ttd_digital');
    if ($fileTtd && $fileTtd->isValid() && !$fileTtd->hasMoved()) {
        $newName = $fileTtd->getRandomName();
        $fileTtd->move(FCPATH . 'uploads/ttd', $newName);

        $data['ttd_digital'] = $newName;

        log_activity(
            'upload_ttd_digital',
            'Mengunggah atau memperbarui tanda tangan digital',
            'user',
            $userId
        );
    }

    // =========================
    // UPDATE DATABASE
    // =========================
    $userModel->update($userId, $data);

    log_activity(
        'update_profile',
        'Memperbarui data profil',
        'user',
        $userId
    );

    // =========================
    // NOTIFIKASI
    // =========================
    $notifModel = new NotificationModel();
    $notifModel->insert([
        'user_id'    => $userId,
        'message'    => 'Profil Anda berhasil diperbarui.',
        'meta'       => json_encode(['type' => 'profile_update']),
        'status'     => 'unread',
        'created_at' => date('Y-m-d H:i:s')
    ]);

    return redirect()->back()->with('success', 'Profil berhasil diperbarui');
}



}
