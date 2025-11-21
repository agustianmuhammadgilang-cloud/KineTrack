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

    $data = [
        'indikator_id' => $post['indikator_id'],
        'realisasi' => $post['realisasi'],
        'progress' => $post['progress'],
        'kendala' => $post['kendala'],
        'strategi' => $post['strategi'],
        'data_dukung' => $post['data_dukung'],
        'created_by' => session('user_id')
    ];

    if($file && $file->isValid() && !$file->hasMoved()){
        $newName = $file->getRandomName();
        $file->move(FCPATH.'uploads/pengukuran/',$newName);
        $data['file_dukung'] = $newName;
    }

    $pengukuranModel = new \App\Models\PengukuranModel();
    $pengukuranModel->insert($data);

    return redirect()->to('/staff/task')->with('success','Data pengukuran berhasil disimpan');
}
}