<?php
namespace App\Models;
use CodeIgniter\Model;

class PengukuranModel extends Model
{
    protected $table = 'pengukuran_kinerja';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'indikator_id',
        'tahun_id',
        'triwulan',
        'realisasi',
        'progress',
        'kendala',
        'strategi',
        'file_dukung',
        'user_id', // relasi ke PIC
        'created_at',   // ✅ TAMBAH
        'updated_at'    // 🔥 INI KUNCINYA
    ];

    protected $returnType = 'array';
    protected $useTimestamps = true;

    /**
     * Ambil semua pengukuran per indikator + triwulan
     * Bisa difilter per user jika $userId diisi
     */
    public function getPengukuran($indikatorId, $tw, $tahunId, $userId = null)
    {
        $builder = $this->where('indikator_id', $indikatorId)
                        ->where('triwulan', $tw)
                        ->where('tahun_id', $tahunId);

        if ($userId) {
            $builder->where('user_id', $userId);
        }

        return $builder->first();
    }
}
