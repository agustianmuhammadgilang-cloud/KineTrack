<?php

namespace App\Controllers\Atasan;

use App\Controllers\BaseController;
use App\Models\UserModel;
// Controller untuk mengelola profil atasan 

class Profile extends BaseController
{
    // Menampilkan halaman profil
    public function index()
    {
        $model = new UserModel();
        $data['user'] = $model->find(session('user_id'));

        return view('atasan/profile', $data);
    }
// Memperbarui profil
    public function update()
{
    $model = new UserModel();
    $id = session('user_id');

    $oldUser = $model->find($id); // ambil data lama buat log

    $input = [
        'nama'  => $this->request->getPost('nama'),
        'email' => $this->request->getPost('email')
    ];

    $password = $this->request->getPost('password');
    $passwordChanged = false;

    if ($password) {
        $input['password'] = password_hash($password, PASSWORD_DEFAULT);
        $passwordChanged = true;
    }

    $model->update($id, $input);

    // =========================
    // LOG AKTIVITAS
    // =========================
    $changes = [];

    if ($oldUser['nama'] !== $input['nama']) {
        $changes[] = "nama";
    }

    if ($oldUser['email'] !== $input['email']) {
        $changes[] = "email";
    }

    if ($passwordChanged) {
        $changes[] = "password";
    }

    log_activity(
        'update_profile',
        'Memperbarui profil akun (' . implode(', ', $changes) . ')',
        'user',
        $id
    );

    return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
}
}
