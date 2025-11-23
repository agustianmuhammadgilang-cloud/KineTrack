<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');   // ← USER LOGIN, bukan admin tetap!

        $userModel = new UserModel();
        $data['admin'] = $userModel->find($userId);

        return view('admin/profile/index', $data);
    }

    public function update()
    {
        $userId = session()->get('user_id');   // ← Yang login
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

        // FOTO OPTIONAL
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {

            // delete foto lama
            if (!empty($admin['foto']) && file_exists('uploads/user/'.$admin['foto'])) {
                unlink('uploads/user/'.$admin['foto']);
            }

            $namaBaru = $foto->getRandomName();
            $foto->move('uploads/user/', $namaBaru);

            $updateData['foto'] = $namaBaru;
        }

        // UPDATE dengan WHERE id = user yg login
        $userModel->update($userId, $updateData);

        return redirect()->back()->with('alert', [
            'type' => 'success',
            'title' => 'Berhasil',
            'message' => 'Profil berhasil diperbarui.'
        ]);
    }
}