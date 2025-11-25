<?php

namespace App\Models;

use CodeIgniter\Model;

class PicModel extends Model
{
    protected $table = 'pic_indikator';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'indikator_id',
        'user_id',
        'tahun_id',
        'sasaran_id',
        'tw',
        'bidang_id',
        'jabatan_id',
        'created_at'
    ];
    protected $useTimestamps = true;

    public function getTasksForUser($userId)
{
    return $this->select('pic_indikator.*, indikator_kinerja.nama_indikator, tahun_anggaran.tahun, sasaran_strategis.nama_sasaran')
                ->join('indikator_kinerja', 'indikator_kinerja.id = pic_indikator.indikator_id')
                ->join('tahun_anggaran', 'tahun_anggaran.id = pic_indikator.tahun_id')
                ->join('sasaran_strategis', 'sasaran_strategis.id = pic_indikator.sasaran_id') // <-- tabel benar
                ->where('pic_indikator.user_id', $userId)
                ->orderBy('tahun_anggaran.tahun', 'DESC')
                ->findAll();
}


    public function getPicByIndikator($indikatorId)
    {
        return $this->select('pic_indikator.*, users.nama, users.email, bidang.nama_bidang, jabatan.nama_jabatan')
                    ->join('users','users.id = pic_indikator.user_id')
                    ->join('bidang','bidang.id = pic_indikator.bidang_id')
                    ->join('jabatan','jabatan.id = pic_indikator.jabatan_id')
                    ->where('pic_indikator.indikator_id', $indikatorId)
                    ->orderBy('pic_indikator.created_at','ASC')
                    ->findAll();
    }

    public function countPendingTasks($userId)
{
    return $this->select('pic_indikator.id')
        ->join('pengukuran_kinerja', 'pengukuran_kinerja.indikator_id = pic_indikator.indikator_id AND pengukuran_kinerja.user_id = pic_indikator.user_id', 'left')
        ->where('pic_indikator.user_id', $userId)
        ->where('pengukuran_kinerja.id IS NULL') // artinya belum diisi
        ->countAllResults();
}

}
