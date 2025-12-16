<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\JabatanModel;
use App\Models\BidangModel;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data['users'] = $this->userModel
            ->select('users.*, jabatan.nama_jabatan, bidang.nama_bidang')
            ->join('jabatan', 'jabatan.id = users.jabatan_id', 'left')
            ->join('bidang', 'bidang.id = users.bidang_id', 'left')
            ->findAll();

        return view('admin/users/index', $data);
    }

    public function create()
    {
        $data['jabatan'] = (new JabatanModel())->findAll();
        $data['bidang']  = (new BidangModel())->findAll();
        return view('admin/users/create', $data);
    }

    public function store()
    {
        $nama  = $this->request->getPost('nama');
        $email = $this->request->getPost('email');

        // Cek duplikat
        $existing = $this->userModel
            ->where('nama', $nama)
            ->orWhere('email', $email)
            ->first();

        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'Akun dengan nama atau email ini sudah terdaftar!');
        }

        $this->userModel->insert([
            'nama'       => $nama,
            'email'      => $email,
            'jabatan_id' => $this->request->getPost('jabatan_id'),
            'bidang_id'  => $this->request->getPost('bidang_id'),
            'role'       => $this->request->getPost('role'),
            'password'   => password_hash('123456', PASSWORD_DEFAULT) // password default
        ]);

        return redirect()->to('/admin/users')->with('success', 'User berhasil ditambahkan. Password default: 123456');
    }

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

    public function update($id)
    {
        $nama  = $this->request->getPost('nama');
        $email = $this->request->getPost('email');

        // Cek duplikat kecuali user yang sedang diupdate
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

        $this->userModel->update($id, [
            'nama'       => $nama,
            'email'      => $email,
            'jabatan_id' => $this->request->getPost('jabatan_id'),
            'bidang_id'  => $this->request->getPost('bidang_id'),
            'role'       => $this->request->getPost('role'),
        ]);

        return redirect()->to('/admin/users')->with('success', 'User berhasil diupdate.');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        return redirect()->to('/admin/users')->with('success', 'User berhasil dihapus.');
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
