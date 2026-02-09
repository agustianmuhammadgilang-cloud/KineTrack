<?php

namespace App\Models;

use CodeIgniter\Model;

class RekomendasiPengukuranModel extends Model
{
    protected $table            = 'rekomendasi_pengukuran';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['tahun_id', 'triwulan', 'isi_rekomendasi', 'pimpinan_id'];

    // Timestamp otomatis
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Ambil semua rekomendasi tahun tertentu dengan nama pimpinan
    public function getFullHistory($tahunId)
    {
        return $this->select('rekomendasi_pengukuran.*, users.nama as pimpinan_nama, tahun_anggaran.tahun')
                    ->join('users', 'users.id = rekomendasi_pengukuran.pimpinan_id', 'left')
                    ->join('tahun_anggaran', 'tahun_anggaran.id = rekomendasi_pengukuran.tahun_id')
                    ->where('rekomendasi_pengukuran.tahun_id', $tahunId)
                    ->orderBy('rekomendasi_pengukuran.triwulan', 'DESC')
                    ->findAll();
    }

    public function getByPeriode($tahunId, $triwulan)
    {
        return $this->where('tahun_id', $tahunId)
                    ->where('triwulan', $triwulan)
                    ->first();
    }
}