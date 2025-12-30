<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\LaporanModel;
use App\Models\UserModel;

// Controller untuk mengelola laporan staff
class Laporan extends BaseController
{
    // Menampilkan halaman daftar laporan
    public function index()
{
    // Ambil model laporan dan user
    $laporanModel = new LaporanModel();
    $userModel = new UserModel();

    // Ambil data staff yang sedang login
    $staff = $userModel
        ->select('users.*, jabatan.nama_jabatan, bidang.nama_bidang')
        ->join('jabatan', 'jabatan.id = users.jabatan_id', 'left')
        ->join('bidang', 'bidang.id = users.bidang_id', 'left')
        ->find(session('user_id'));

    // Ambil laporan milik staff yang sedang login
    $data = [
        'staff' => $staff,
        'laporan' => $laporanModel->where('user_id', session('user_id'))->findAll()
    ];
    // Hitung jumlah tugas pending untuk notifikasi
    helper('globalcount');
$data['pending_task_count'] = getPendingTaskCount(session('user_id'));


    return view('staff/laporan/index', $data);
}

    // Menampilkan form tambah laporan
    public function create()
    {
        return view('staff/laporan/create');
    }
    // Menyimpan laporan baru
    public function store()
    {
        $model = new LaporanModel();

        $file = $this->request->getFile('file_bukti');
        $fileName = null;

        if ($file && $file->isValid()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/bukti', $fileName);
        }

        $model->insert([
            'user_id'   => session('user_id'),
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'tanggal'   => $this->request->getPost('tanggal'),
            'file_bukti'=> $fileName,
            'status'    => 'pending'
        ]);

        session()->setFlashdata('alert', [
        'type' => 'success',
        'title' => 'Berhasil!',
        'message' => 'Laporan berhasil dikirim.'
    ]);


        return redirect()->to('/staff/laporan')->with('success', 'Laporan berhasil dikirim!');

        
    }
    // Menampilkan detail laporan ditolak
    public function rejected($id)
{
    $model = new LaporanModel();

    $data['lap'] = $model
        ->select('laporan.*, users.nama')
        ->join('users', 'users.id = laporan.user_id')
        ->find($id);

        session()->setFlashdata('alert', [
        'type' => 'warning',
        'title' => 'Laporan Ditolak',
        'message' => 'Silakan perbaiki laporan Anda sesuai catatan atasan.'
    ]);


    

    return view('staff/laporan/rejected_detail', $data);

    
}
// Mengirim ulang laporan yang ditolak
public function resubmit($id)
{
    $model = new LaporanModel();

    // upload file baru
    $file = $this->request->getFile('file_bukti');
    $fileName = $this->request->getPost('file_lama'); // default file lama

    if ($file && $file->isValid()) {
        $fileName = $file->getRandomName();
        $file->move('uploads/bukti', $fileName);
    }

    $model->update($id, [
        'judul'     => $this->request->getPost('judul'),
        'deskripsi' => $this->request->getPost('deskripsi'),
        'tanggal'   => $this->request->getPost('tanggal'),
        'file_bukti'=> $fileName,
        'status'    => 'pending',
        'catatan_atasan' => null
    ]);

    session()->setFlashdata('alert', [
    'type' => 'success',
    'title' => 'Berhasil Dikirim Ulang',
    'message' => 'Laporan berhasil diperbaiki dan dikirim ulang.'
    ]);


    return redirect()->to('/staff/laporan')->with('success', 'Laporan berhasil dikirim ulang!');
}

}
