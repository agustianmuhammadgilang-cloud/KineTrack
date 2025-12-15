<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');

        $userModel = new UserModel();
        $data['admin'] = $userModel->find($userId);

        return view('admin/profile/index', $data);
    }

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

        // FOTO OPTIONAL
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {

            // Delete foto lama
            if (!empty($admin['foto']) && file_exists('uploads/profile/' . $admin['foto'])) {
                unlink('uploads/profile/' . $admin['foto']);
            }

            // Upload foto baru
            $namaBaru = $foto->getRandomName();
            $foto->move('uploads/profile/', $namaBaru);

            $updateData['foto'] = $namaBaru;

            // UPDATE SESSION FOTO
            session()->set('foto', $namaBaru);
        }

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