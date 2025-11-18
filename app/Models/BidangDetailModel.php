<?php

namespace App\Models;

use CodeIgniter\Model;

class BidangDetailModel extends Model
{
    protected $table = 'users';

    // ambil pegawai di bidang tertentu
    public function getPegawaiByBidang($bidangId)
    {
        return $this->select('users.*, jabatan.nama_jabatan')
            ->join('jabatan', 'jabatan.id = users.jabatan_id', 'left')
            ->where('users.bidang_id', $bidangId)
            ->where('users.role', 'staff') 
            ->findAll();
    }

    // hitung total laporan bulan ini
    public function countLaporanBulanan($userId)
    {
        $bulan = date('m');
        $tahun = date('Y');

        return model('LaporanModel')
            ->where('user_id', $userId)
            ->where('MONTH(tanggal)', $bulan)
            ->where('YEAR(tanggal)', $tahun)
            ->where('status', 'approved')
            ->countAllResults();
    }

    // hitung total laporan bulan lalu
    public function countLaporanBulanLalu($userId)
    {
        $bulan = date('m') - 1;
        if ($bulan == 0) { $bulan = 12; }

        $tahun = date('Y');

        return model('LaporanModel')
            ->where('user_id', $userId)
            ->where('MONTH(tanggal)', $bulan)
            ->where('YEAR(tanggal)', $tahun)
            ->where('status', 'approved')
            ->countAllResults();
    }
}
