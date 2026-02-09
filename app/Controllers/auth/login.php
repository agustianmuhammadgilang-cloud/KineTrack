<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;
// Controller untuk mengelola proses login
class Login extends BaseController
{
    // Menampilkan halaman login
    public function index()
{
    // Buat captcha
    $a = rand(1, 9);
    $b = rand(1, 9);
    session()->set('math_captcha_answer', $a + $b);

    return view('auth/login', [
        'a' => $a,
        'b' => $b
    ]);
}

    // Proses login
    public function process()
    {
        $session = session();
        $model   = new UserModel();

        $email    = trim($this->request->getPost('email'));
        $password = trim($this->request->getPost('password'));
        $captcha  = trim($this->request->getPost('captcha_answer'));

        // Cek captcha
        if ($captcha != session()->get('math_captcha_answer')) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jawaban captcha salah.');
        }

        // Validasi kosong
        if (empty($email) || empty($password)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email dan password tidak boleh kosong.');
        }

        // Cek email
        $user = $model->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email tidak ditemukan.');
        }

        // Cek password
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Password salah.');
        }

        // Set session
        $session->set([
            'user_id'    => $user['id'],
            'nama'       => $user['nama'],
            'email'      => $user['email'],
            'role'       => $user['role'],
            'bidang_id'  => $user['bidang_id'],
            'jabatan_id' => $user['jabatan_id'],
            'foto'       => $user['foto'],
            'logged_in'  => true
        ]);

        // LOG AKTIVITAS
        log_activity(
    'login',
    'Login ke sistem'
);


        // Redirect sesuai role
            switch ($user['role']) {
        case 'admin':
            return redirect()->to('/admin');

        case 'pimpinan':
            return redirect()->to('/pimpinan');

        case 'atasan':
            return redirect()->to('/atasan');

        case 'staff':
        default:
            return redirect()->to('/staff/dashboard');
    }
    }
    // Proses logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
