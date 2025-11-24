<?php
namespace App\Controllers\Staff;
use App\Controllers\BaseController;
use App\Models\PicModel;

class TaskController extends BaseController
{
    protected $picModel;

    public function __construct()
    {
        $this->picModel = new PicModel();
    }
public function index()
{
    $userId = session('user_id');

    $data['tasks'] = $this->picModel->getTasksForUser($userId);

    // Hitung task yang belum dikerjakan
    $data['pending_count'] = $this->picModel->countPendingTasks($userId);

    return view('staff/task/index', $data);
}


    public function input($indikatorId)
    {
        // tampilkan form input realisasi, progress, kendala, strategi, data_dukung, file_dukung
        return view('staff/task/input', ['indikator_id'=>$indikatorId]);
    }

    public function store()
{
    $post = $this->request->getPost();
    $file = $this->request->getFile('file_dukung');

    // ambil data PIC (tahun_id dan sasaran_id)
    $pic = $this->picModel
        ->where('indikator_id', $post['indikator_id'])
        ->where('user_id', session('user_id'))
        ->first();

    if (!$pic) {
        return redirect()->back()->with('error', 'PIC tidak ditemukan untuk indikator ini');
    }

    $data = [
        'indikator_id' => $post['indikator_id'],
        'tahun_id'     => $pic['tahun_id'],
        'sasaran_id'   => $pic['sasaran_id'],
        'user_id'      => session('user_id'),   // ⬅⬅⬅ FIX PALING PENTING
        'realisasi'    => $post['realisasi'],
        'progress'     => $post['progress'],
        'kendala'      => $post['kendala'],
        'strategi'     => $post['strategi'],
        'created_by'   => session('user_id')
    ];

    // upload file
    if ($file && $file->isValid() && !$file->hasMoved()) {
        $newName = $file->getRandomName();
        $file->move(FCPATH . 'uploads/pengukuran/', $newName);
        $data['file_dukung'] = $newName;
    }

    // simpan
    $pengukuranModel = new \App\Models\PengukuranModel();
    $pengukuranModel->insert($data);

    return redirect()->to('/staff/task')->with('success','Data pengukuran berhasil disimpan');
}


}