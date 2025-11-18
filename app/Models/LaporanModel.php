<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table = 'laporan';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'judul',
        'deskripsi',
        'tanggal',
        'file_bukti',
        'status',
        'catatan_atasan'
    ];

    protected $returnType = 'array';

    public function getDailyData($userId)
{
    return $this->select("DATE(tanggal) as tgl, COUNT(*) as total")
                ->where('user_id', $userId)
                ->groupBy('DATE(tanggal)')
                ->orderBy('tgl', 'ASC')
                ->findAll();
}

public function getWeeklyData($userId)
{
    return $this->select("WEEK(tanggal) as minggu, COUNT(*) as total")
                ->where('user_id', $userId)
                ->groupBy('minggu')
                ->orderBy('minggu', 'ASC')
                ->findAll();
}

public function getMonthlyData($userId)
{
    return $this->select("MONTH(tanggal) as bulan, COUNT(*) as total")
                ->where('user_id', $userId)
                ->groupBy('bulan')
                ->orderBy('bulan', 'ASC')
                ->findAll();
}

}
