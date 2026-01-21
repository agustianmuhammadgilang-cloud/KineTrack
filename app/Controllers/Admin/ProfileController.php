<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
// Controller untuk mengelola profil admin
class ProfileController extends BaseController
{
    // Menampilkan halaman profil admin                                                                                                                                 
    public function index()
    {
        $userId = session()->get('user_id');

        $userModel = new UserModel();
        $data['admin'] = $userModel->find($userId);

        return view('admin/profile/index', $data);
    }
// Memperbarui profil admin
    public function update()
    {
        $userId = session()->get('user_id');
        $userModel = new UserModel();

        $admin = $userModel->find($userId);

        // VALIDASI EMAIL UNIK
        $emailBaru = $this->request->getPost('email');

        if ($emailBaru !== $admin['email']) {
            if ($userModel->where('email', $emailBaru)->first()) {
                return redirect()->back()
                    ->with('alert', [
                        'type' => 'error',
                        'title' => 'Email sudah digunakan',
                        'message' => 'Gunakan email lain.'
                    ]);
            }
        }

        // DATA UPDATE
        $updateData = [
            'nama'  => $this->request->getPost('nama'),
            'email' => $emailBaru,
        ];

        // PASSWORD OPTIONAL
        $passwordBaru = $this->request->getPost('password');
        if (!empty($passwordBaru)) {
            $updateData['password'] = password_hash($passwordBaru, PASSWORD_DEFAULT);
        }

        // --- REVISI BAGIAN FOTO OPTIONAL ---
$fotoCropped = $this->request->getPost('foto_cropped');

if (!empty($fotoCropped)) {
    // 1. Logika jika user menggunakan fitur CROP (Base64)
    
    // Hapus foto lama jika ada
    if (!empty($admin['foto']) && file_exists('uploads/profile/' . $admin['foto'])) {
        unlink('uploads/profile/' . $admin['foto']);
    }

    // Olah data Base64: "data:image/jpeg;base64,/9j/4AAQ..."
    list($type, $data) = explode(';', $fotoCropped);
    list(, $data)      = explode(',', $data);
    $decodedData = base64_decode($data);

    // Buat nama file unik (pertahankan format jpg/png sesuai kebutuhan)
    $namaBaru = 'profile_' . $userId . '_' . time() . '.jpg';
    $path = 'uploads/profile/' . $namaBaru;

    // Simpan data string ke folder sebagai file fisik
    if (file_put_contents($path, $decodedData)) {
        $updateData['foto'] = $namaBaru;
        session()->set('foto', $namaBaru);
    }

} else {
    // 2. Logika Fallback (tetap pertahankan upload biasa jika tidak ada data crop)
    $foto = $this->request->getFile('foto');
    if ($foto && $foto->isValid() && !$foto->hasMoved()) {
        if (!empty($admin['foto']) && file_exists('uploads/profile/' . $admin['foto'])) {
            unlink('uploads/profile/' . $admin['foto']);
        }
        $namaBaru = $foto->getRandomName();
        $foto->move('uploads/profile/', $namaBaru);
        
        $updateData['foto'] = $namaBaru;
        session()->set('foto', $namaBaru);
    }
}
// --- AKHIR REVISI FOTO ---

        // TTD ADMIN
$ttd = $this->request->getFile('ttd_digital');
if ($ttd && $ttd->isValid() && !$ttd->hasMoved()) {

    if (!empty($admin['ttd_digital']) && file_exists('uploads/ttd/'.$admin['ttd_digital'])) {
        unlink('uploads/ttd/'.$admin['ttd_digital']);
    }

    $ttdName = 'ttd_admin_'.$userId.'.'.$ttd->getExtension();
    $ttd->move('uploads/ttd/', $ttdName, true);

    $updateData['ttd_digital'] = $ttdName;
    session()->set('ttd_digital', $ttdName);
}


        // UPDATE DATA USER
        $userModel->update($userId, $updateData);
        $changed = [];

if ($updateData['nama'] !== $admin['nama']) {
    $changed[] = 'nama';
}

if ($updateData['email'] !== $admin['email']) {
    $changed[] = 'email';
}

if (!empty($passwordBaru)) {
    $changed[] = 'password';
}

if (isset($updateData['foto'])) {
    $changed[] = 'foto profil';
}

if (isset($updateData['ttd_digital'])) {
    $changed[] = 'TTD digital';
}
if (!empty($changed)) {
    log_activity(
        'update_profile',
        'Memperbarui profil admin: ' . implode(', ', $changed),
        'users',
        $userId
    );
}


        // UPDATE SESSION LAINNYA
        session()->set('nama', $updateData['nama']);
        session()->set('email', $updateData['email']);

        return redirect()->back()->with('alert', [
            'type' => 'success',
            'title' => 'Berhasil',
            'message' => 'Profil berhasil diperbarui.'
        ]);
    }
}