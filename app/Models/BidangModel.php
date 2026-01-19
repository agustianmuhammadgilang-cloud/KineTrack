<?php

namespace App\Models;

use CodeIgniter\Model;

class BidangModel extends Model
{
    protected $table = 'bidang';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_bidang','jenis_unit','parent_id'];
    protected $returnType = 'array';

     /* ===============================
     * SEARCH BIDANG (JURUSAN / PRODI)
     * =============================== */
    public function searchBidang($keyword)
    {
        return $this->like('nama_bidang', $keyword)
                    ->findAll();
    }

    /* ===============================
     * AMBIL JURUSAN BY ID
     * =============================== */
    public function getJurusanById($id)
    {
        return $this->where('id', $id)
                    ->where('jenis_unit', 'jurusan')
                    ->first();
    }

    /* ===============================
     * AMBIL PRODI BERDASARKAN JURUSAN
     * =============================== */
    public function getProdiByJurusan($jurusanId)
    {
        return $this->where('jenis_unit', 'prodi')
                    ->where('parent_id', $jurusanId)
                    ->findAll();
    }

    /* ===============================
     * AMBIL SEMUA JURUSAN
     * =============================== */
    public function getAllJurusan()
    {
        return $this->where('jenis_unit', 'jurusan')->findAll();
    }

    /* ===============================
     * AMBIL SEMUA PRODI
     * =============================== */
    public function getAllProdi()
    {
        return $this->where('jenis_unit', 'prodi')->findAll();
    }
}
