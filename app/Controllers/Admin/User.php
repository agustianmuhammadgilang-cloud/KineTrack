<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\JabatanModel;
use App\Models\BidangModel;

class User extends BaseController
{
    public function index()
    {
        $userModel   = new UserModel();
        $jabatanModel = new JabatanModel();
        $bidangModel  = new BidangModel();

        $data['users'] = $userModel
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
        $userModel = new UserModel();

        $userModel->insert([
            'nama'       => $this->request->getPost('nama'),
            'email'      => $this->request->getPost('email'),
            'jabatan_id' => $this->request->getPost('jabatan_id'),
            'bidang_id'  => $this->request->getPost('bidang_id'),
            'role'       => $this->request->getPost('role'),
            'password'   => password_hash('123456', PASSWORD_DEFAULT) // password default
        ]);

        return redirect()->to('/admin/users')->with('success', 'User berhasil ditambahkan. Password default: 123456');
    }

    public function edit($id)
    {
        $userModel   = new UserModel();
        $jabatanModel = new JabatanModel();
        $bidangModel  = new BidangModel();

        $data['user']    = $userModel->find($id);
        $data['jabatan'] = $jabatanModel->findAll();
        $data['bidang']  = $bidangModel->findAll();

        return view('admin/users/edit', $data);
    }

    public function update($id)
    {
        $userModel = new UserModel();

        $userModel->update($id, [
            'nama'       => $this->request->getPost('nama'),
            'email'      => $this->request->getPost('email'),
            'jabatan_id' => $this->request->getPost('jabatan_id'),
            'bidang_id'  => $this->request->getPost('bidang_id'),
            'role'       => $this->request->getPost('role'),
        ]);

        return redirect()->to('/admin/users')->with('success', 'User berhasil diupdate.');
    }

    public function delete($id)
    {
        $userModel = new UserModel();
        $userModel->delete($id);

        return redirect()->to('/admin/users')->with('success', 'User berhasil dihapus.');
    }
}
