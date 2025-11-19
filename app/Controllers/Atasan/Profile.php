<?php

namespace App\Controllers\Atasan;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $data['user'] = $model->find(session('user_id'));

        return view('atasan/profile', $data);
    }

    public function update()
    {
        $model = new UserModel();
        $id = session('user_id');

        $input = [
            'nama'  => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email')
        ];

        // jika password diisi, update
        $password = $this->request->getPost('password');
        if ($password) {
            $input['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $model->update($id, $input);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
