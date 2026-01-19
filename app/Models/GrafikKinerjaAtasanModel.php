<?php

namespace App\Models;

use CodeIgniter\Model;

class GrafikKinerjaAtasanModel extends Model
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    /* =====================================================
       AMBIL TAHUN AKTIF (SAMA PERSIS ADMIN)
       ===================================================== */
    public function getTahunAktif()
    {
        return $this->db->table('tahun_anggaran')
            ->where('status', 'active')
            ->get()
            ->getRowArray();
    }

    public function getListTahun()
    {
        return $this->db->table('tahun_anggaran')
            ->orderBy('tahun', 'DESC')
            ->get()
            ->getResultArray();
    }

    /* =====================================================
       GRAFIK INDIKATOR — STAFF (FILTER USER)
       ⚠️ RUMUS PROGRES TIDAK DIUBAH
       ===================================================== */
    public function getGrafikIndikatorByTahun($tahunId, $userId)
{
    return $this->db->query("
        SELECT
            ik.id AS indikator_id,
            ss.kode_sasaran,
            ss.nama_sasaran,
            ik.kode_indikator,
            ik.nama_indikator,
            ik.mode,

            CASE
                WHEN ik.mode = 'akumulatif' THEN ik.target_tw4
                ELSE ik.target_tw1 + ik.target_tw2 + ik.target_tw3 + ik.target_tw4
            END AS target_pk,

            CASE
                WHEN ik.mode = 'akumulatif' THEN COALESCE(MAX(pk.realisasi), 0)
                ELSE
                    LEAST(COALESCE(SUM(CASE WHEN pk.triwulan = 1 THEN pk.realisasi ELSE 0 END),0), ik.target_tw1)
                  + LEAST(COALESCE(SUM(CASE WHEN pk.triwulan = 2 THEN pk.realisasi ELSE 0 END),0), ik.target_tw2)
                  + LEAST(COALESCE(SUM(CASE WHEN pk.triwulan = 3 THEN pk.realisasi ELSE 0 END),0), ik.target_tw3)
                  + LEAST(COALESCE(SUM(CASE WHEN pk.triwulan = 4 THEN pk.realisasi ELSE 0 END),0), ik.target_tw4)
            END AS realisasi,

            LEAST(
                (
                    CASE
                        WHEN ik.mode = 'akumulatif' THEN COALESCE(MAX(pk.realisasi), 0)
                        ELSE
                            LEAST(COALESCE(SUM(CASE WHEN pk.triwulan=1 THEN pk.realisasi ELSE 0 END),0), ik.target_tw1)
                          + LEAST(COALESCE(SUM(CASE WHEN pk.triwulan=2 THEN pk.realisasi ELSE 0 END),0), ik.target_tw2)
                          + LEAST(COALESCE(SUM(CASE WHEN pk.triwulan=3 THEN pk.realisasi ELSE 0 END),0), ik.target_tw3)
                          + LEAST(COALESCE(SUM(CASE WHEN pk.triwulan=4 THEN pk.realisasi ELSE 0 END),0), ik.target_tw4)
                    END
                    /
                    NULLIF(
                        CASE
                            WHEN ik.mode='akumulatif' THEN ik.target_tw4
                            ELSE ik.target_tw1 + ik.target_tw2 + ik.target_tw3 + ik.target_tw4
                        END,
                        0
                    )
                ) * 100,
                100
            ) AS progres

        FROM indikator_kinerja ik
        JOIN sasaran_strategis ss 
            ON ss.id = ik.sasaran_id

        -- 🔐 FILTER KEPEMILIKAN (WAJIB ADA DATA USER)
        INNER JOIN pengukuran_kinerja pk_owner
            ON pk_owner.indikator_id = ik.id
           AND pk_owner.user_id = ?

        -- 🔢 HITUNG REALISASI
        LEFT JOIN pengukuran_kinerja pk
            ON pk.indikator_id = ik.id
           AND pk.user_id = ?

        WHERE ss.tahun_id = ?

        GROUP BY ik.id
        ORDER BY ss.kode_sasaran ASC, ik.kode_indikator ASC
    ", [$userId, $userId, $tahunId])->getResultArray();
}


    /* =====================================================
       GRAFIK TRIWULAN — STAFF (DIRI SENDIRI)
       ===================================================== */
    public function getGrafikTriwulan($indikatorId, $userId)
{
    $indikator = $this->db->table('indikator_kinerja ik')
        ->select('ik.id, ik.sasaran_id, ik.nama_indikator, ik.mode,
                  ik.target_tw1, ik.target_tw2, ik.target_tw3, ik.target_tw4,
                  ss.tahun_id')
        ->join('sasaran_strategis ss', 'ss.id = ik.sasaran_id')
        ->where('ik.id', $indikatorId)
        ->get()
        ->getRowArray();

    if (!$indikator) return null;

    // ambil realisasi staff ini
    $rows = $this->db->table('pengukuran_kinerja pk')
        ->select('pk.triwulan, pk.realisasi, u.nama')
        ->join('users u', 'u.id = pk.user_id')
        ->where([
            'pk.indikator_id' => $indikatorId,
            'pk.user_id'      => $userId
        ])
        ->orderBy('pk.triwulan')
        ->get()
        ->getResultArray();

    // === FORMAT SAMA PERSIS ADMIN ===
    $realisasiPIC = [];

    foreach ($rows as $r) {
        if (!isset($realisasiPIC[$userId])) {
            $realisasiPIC[$userId] = [
                'nama' => $r['nama'],
                'data' => [1 => 0, 2 => 0, 3 => 0, 4 => 0]
            ];
        }
        $realisasiPIC[$userId]['data'][$r['triwulan']] += (float)$r['realisasi'];
    }

    $targetTW = [
        1 => (float)$indikator['target_tw1'],
        2 => (float)$indikator['target_tw2'],
        3 => (float)$indikator['target_tw3'],
        4 => (float)$indikator['target_tw4'],
    ];

    // progres (tetap dihitung)
    $totalTW = [1=>0,2=>0,3=>0,4=>0];
    foreach ($realisasiPIC as $pic) {
        foreach ($pic['data'] as $tw => $v) {
            $totalTW[$tw] += $v;
        }
    }

    $progresTW = [];
    if ($indikator['mode'] === 'akumulatif') {
        $t = $r = 0;
        for ($i=1;$i<=4;$i++){
            $t += $targetTW[$i];
            $r += $totalTW[$i];
            $progresTW[$i] = $t > 0 ? min(($r/$t)*100,100) : 0;
        }
    } else {
        for ($i=1;$i<=4;$i++){
            $progresTW[$i] = $targetTW[$i] > 0
                ? min(($totalTW[$i]/$targetTW[$i])*100,100)
                : 0;
        }
    }

    return [
        'indikator'      => $indikator,
        'sasaranId'      => $indikator['sasaran_id'],
        'target'         => $targetTW,
        'realisasi'      => $realisasiPIC, // 🔑 PENTING
        'totalRealisasi' => $totalTW,
        'progres'        => $progresTW,
        'mode'           => $indikator['mode']
    ];
}

}
