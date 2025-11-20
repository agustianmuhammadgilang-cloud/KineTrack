<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\TahunAnggaranModel;

class Login extends BaseController
{
    public function index()
    {
         $tahunModel = new TahunAnggaranModel();
    $data['tahun'] = $tahunModel->findAll();

    return view('auth/login', $data);
    }

    public function process()
    {
        $tahun = $this->request->getPost('tahun');
        session()->set('tahun_id', $tahun);

        $session = session();
        $model = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan.');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah.');
        }

        // SET SESSION
        $session->set([
            'user_id'    => $user['id'],
            'nama'       => $user['nama'],
            'email'      => $user['email'],
            'role'       => $user['role'],
            'bidang_id'  => $user['bidang_id'],   // WAJIB
            'jabatan_id' => $user['jabatan_id'],  // (opsional, tapi bagus ditambah)
            'logged_in'  => true
        ]);


        // Redirect based on role
        if ($user['role'] == 'admin') {
            return redirect()->to('/admin');
        } elseif ($user['role'] == 'atasan') {
            return redirect()->to('/atasan');
        } else {
            return redirect()->to('/staff/dashboard');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
