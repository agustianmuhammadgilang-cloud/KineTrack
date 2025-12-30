<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\JabatanModel;
use App\Models\BidangModel;
// Controller untuk mengelola user
class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }
// Menampilkan daftar user
    public function index()
    {
        $data['users'] = $this->userModel
            ->select('users.*, jabatan.nama_jabatan, bidang.nama_bidang')
            ->join('jabatan', 'jabatan.id = users.jabatan_id', 'left')
            ->join('bidang', 'bidang.id = users.bidang_id', 'left')
            ->findAll();

        return view('admin/users/index', $data);
    }
// Menampilkan form untuk menambahkan user baru
    public function create()
    {
        $data['jabatan'] = (new JabatanModel())->findAll();
        $data['bidang']  = (new BidangModel())->findAll();
        return view('admin/users/create', $data);
    }
// Menyimpan user baru
    public function store()
{
    $nama       = $this->request->getPost('nama');
    $email      = $this->request->getPost('email');
    $jabatan_id = $this->request->getPost('jabatan_id');
    $bidang_id  = $this->request->getPost('bidang_id');

    // Cek duplikat
    $existing = $this->userModel
        ->where('nama', $nama)
        ->orWhere('email', $email)
        ->first();

    if ($existing) {
        return redirect()->back()->withInput()->with('error', 'Akun dengan nama atau email ini sudah terdaftar!');
    }

    //  Ambil jabatan → tentukan role
    $jabatan = (new JabatanModel())->find($jabatan_id);

    if (!$jabatan || empty($jabatan['default_role'])) {
        return redirect()->back()->withInput()->with('error', 'Jabatan tidak valid atau belum memiliki role sistem.');
    }

    //  Simpan user (ROLE AUTO)
    $userId = $this->userModel->insert([
    'nama'       => $nama,
    'email'      => $email,
    'jabatan_id' => $jabatan_id,
    'bidang_id'  => $bidang_id,
    'role'       => $jabatan['default_role'],
    'password'   => password_hash('123456', PASSWORD_DEFAULT)
]);

    //  LOG AKTIVITAS ADMIN
log_activity(
    'create_user',
    'Menambahkan user baru: ' . $nama,
    'users',
    $userId
);





    return redirect()->to('/admin/users')
        ->with('success', 'User berhasil ditambahkan. Password default: 123456');
}

// Menampilkan form untuk mengedit user
    public function edit($id)
    {
        $userModel   = $this->userModel;
        $jabatanModel = new JabatanModel();
        $bidangModel  = new BidangModel();

        $data['user']    = $userModel->find($id);
        $data['jabatan'] = $jabatanModel->findAll();
        $data['bidang']  = $bidangModel->findAll();

        return view('admin/users/edit', $data);
    }
// Memperbarui user
    public function update($id)
{
    $nama       = $this->request->getPost('nama');
    $email      = $this->request->getPost('email');
    $jabatan_id = $this->request->getPost('jabatan_id');
    $bidang_id  = $this->request->getPost('bidang_id');

    //  Cek duplikat kecuali diri sendiri
    $existing = $this->userModel
        ->where('id !=', $id)
        ->groupStart()
            ->where('nama', $nama)
            ->orWhere('email', $email)
        ->groupEnd()
        ->first();

    if ($existing) {
        return redirect()->back()->withInput()->with('error', 'Akun dengan nama atau email ini sudah terdaftar!');
    }

    // Ambil role dari jabatan
    $jabatan = (new JabatanModel())->find($jabatan_id);

    if (!$jabatan || empty($jabatan['default_role'])) {
        return redirect()->back()->withInput()->with('error', 'Jabatan tidak valid atau belum memiliki role sistem.');
    }

    //  Update user
    $this->userModel->update($id, [
        'nama'       => $nama,
        'email'      => $email,
        'jabatan_id' => $jabatan_id,
        'bidang_id'  => $bidang_id,
        'role'       => $jabatan['default_role'] // 🔥 AUTO
    ]);
// LOG AKTIVITAS
    log_activity(
    'update_user',
    'Mengubah data user: ' . $nama,
    'users',
    $id
);


    return redirect()->to('/admin/users')->with('success', 'User berhasil diupdate.');
}

// Menghapus user
    public function delete($id)
{
    $user = $this->userModel->find($id);

    if ($user) {
        $this->userModel->delete($id);

        log_activity(
            'delete_user',
            'Menghapus user: ' . $user['nama'],
            'users',
            $id
        );
    }

    return redirect()->to('/admin/users')
        ->with('success', 'User berhasil dihapus.');
}


    // Endpoint Ajax untuk cek duplicate
    public function checkDuplicate()
    {
        $data = $this->request->getJSON(true);

        $nama  = $data['nama'] ?? '';
        $email = $data['email'] ?? '';

        $exists = $this->userModel
            ->where('nama', $nama)
            ->orWhere('email', $email)
            ->first();

        return $this->response->setJSON(['exists' => $exists ? true : false]);
    }
}
