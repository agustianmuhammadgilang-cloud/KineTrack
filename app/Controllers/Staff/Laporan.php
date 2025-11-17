<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\LaporanModel;

class Laporan extends BaseController
{
    public function index()
    {
        $model = new LaporanModel();

        $data['laporan'] = $model
            ->where('user_id', session('user_id'))
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('staff/laporan/index', $data);
    }

    public function create()
    {
        return view('staff/laporan/create');
    }

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

        return redirect()->to('/staff/laporan')->with('success', 'Laporan berhasil dikirim!');
    }

    public function rejected($id)
{
    $model = new LaporanModel();

    $data['lap'] = $model
        ->select('laporan.*, users.nama')
        ->join('users', 'users.id = laporan.user_id')
        ->find($id);

    return view('staff/laporan/rejected_detail', $data);
}

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

    return redirect()->to('/staff/laporan')->with('success', 'Laporan berhasil dikirim ulang!');
}

}
