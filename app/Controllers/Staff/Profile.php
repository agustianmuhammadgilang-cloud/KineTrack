<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\NotificationModel;
// Controller untuk mengelola profil staff
class Profile extends BaseController
{
    // Menampilkan halaman profil staff
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

        return view('staff/profile', $data);
    }

    // Memperbarui data profil staff
public function update()
{
    $userId    = session()->get('user_id');
    $userModel = new \App\Models\UserModel();
    $user      = $userModel->find($userId);

    // =========================
    // 1. INISIALISASI DATA UPDATE
    // =========================
    $updateData = [
        'nama'  => $this->request->getPost('nama'),
        'email' => $this->request->getPost('email'),
    ];

    // Cek password jika diisi
    $password = $this->request->getPost('password');
    if (!empty($password)) {
        $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
    }

    // =========================
    // 2. LOGIKA FOTO PROFIL (CROPPER & FALLBACK)
    // =========================
    $fotoCropped = $this->request->getPost('foto_cropped');

    if (!empty($fotoCropped)) {
        // Hapus foto lama jika ada
        if (!empty($user['foto']) && file_exists('uploads/profile/' . $user['foto'])) {
            unlink('uploads/profile/' . $user['foto']);
        }

        // Olah data Base64 - Variabel penampung diubah agar TIDAK bentrok dengan $updateData
        list($type, $base64String) = explode(';', $fotoCropped);
        list(, $base64String)      = explode(',', $base64String);
        $decodedData = base64_decode($base64String);

        $namaBaruFoto = 'atasan_' . $userId . '_' . time() . '.jpg';
        $pathFoto     = 'uploads/profile/' . $namaBaruFoto;

        if (file_put_contents($pathFoto, $decodedData)) {
            $updateData['foto'] = $namaBaruFoto;
            session()->set('foto', $namaBaruFoto);
        }
    } else {
        // Fallback: Upload biasa
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            if (!empty($user['foto']) && file_exists('uploads/profile/' . $user['foto'])) {
                unlink('uploads/profile/' . $user['foto']);
            }
            $namaBaruFoto = $foto->getRandomName();
            $foto->move('uploads/profile/', $namaBaruFoto);
            
            $updateData['foto'] = $namaBaruFoto;
            session()->set('foto', $namaBaruFoto);
        }
    }

    // =========================
    // 3. TTD DIGITAL (EXISTING)
    // =========================
    $fileTtd = $this->request->getFile('ttd_digital');
    if ($fileTtd && $fileTtd->isValid() && !$fileTtd->hasMoved()) {
        // Hapus TTD lama jika ingin folder tetap bersih
        if (!empty($user['ttd_digital']) && file_exists('uploads/ttd/' . $user['ttd_digital'])) {
            unlink('uploads/ttd/' . $user['ttd_digital']);
        }

        $newNameTtd = $fileTtd->getRandomName();
        $fileTtd->move(FCPATH . 'uploads/ttd', $newNameTtd);

        $updateData['ttd_digital'] = $newNameTtd;

        log_activity(
            'upload_ttd_digital',
            'Mengunggah atau memperbarui tanda tangan digital',
            'user',
            $userId
        );
    }

    // =========================
    // 4. UPDATE DATABASE
    // =========================
    $userModel->update($userId, $updateData);

    // LOG PROFIL
    log_activity(
        'update_profile',
        'Memperbarui data profil',
        'user',
        $userId
    );

    // =========================
    // 5. NOTIFIKASI & REDIRECT
    // =========================
    $notifModel = new \App\Models\NotificationModel(); // Pastikan namespace benar
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
