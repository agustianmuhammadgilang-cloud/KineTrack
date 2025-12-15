<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $data['user'] = $model->find(session('user_id'));

        return view('staff/profile', $data);
    }

public function update()
{
    $userId = session()->get('user_id');
    $userModel = new \App\Models\UserModel();

    $data = [
        'nama'  => $this->request->getPost('nama'),
        'email' => $this->request->getPost('email'),
    ];

    // ================= TTD UPLOAD =================
    $fileTtd = $this->request->getFile('ttd_digital');

    if ($fileTtd && $fileTtd->isValid() && !$fileTtd->hasMoved()) {
        $newName = $fileTtd->getRandomName();
        $fileTtd->move(FCPATH . 'uploads/ttd', $newName);

        // SIMPAN NAMA FILE KE DB
        $data['ttd_digital'] = $newName;
    }

    $userModel->update($userId, $data);

    return redirect()->back()->with('success', 'Profil berhasil diperbarui');
}


}
