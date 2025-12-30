<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\UserModel;
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
    // Ambil data dari form
    $userId = session()->get('user_id');
    $userModel = new \App\Models\UserModel();
    // Data yang akan diperbarui
    $data = [
        'nama'  => $this->request->getPost('nama'),
        'email' => $this->request->getPost('email'),
    ];

    // Tangani unggahan file tanda tangan digital jika ada
    $fileTtd = $this->request->getFile('ttd_digital');
    // Jika ada file yang diunggah dan valid
    if ($fileTtd && $fileTtd->isValid() && !$fileTtd->hasMoved()) {
        $newName = $fileTtd->getRandomName();
        $fileTtd->move(FCPATH . 'uploads/ttd', $newName);

        // Simpan nama file tanda tangan digital ke data yang akan diperbarui
        $data['ttd_digital'] = $newName;
        // Log aktivitas unggah tanda tangan digital
        log_activity(
        'upload_ttd_digital',
        'Mengunggah atau memperbarui tanda tangan digital',
        'user',
        $userId
    );
    }
    


    $userModel->update($userId, $data);
    // Log aktivitas pembaruan profil
    log_activity(
    'update_profile',
    'Memperbarui data profil (nama dan email)',
    'user',
    $userId
);


    return redirect()->back()->with('success', 'Profil berhasil diperbarui');
}


}
