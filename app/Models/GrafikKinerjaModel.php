<?php

namespace App\Models;

use CodeIgniter\Model;

class GrafikKinerjaModel extends Model  
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    /* =====================================================
   AMBIL TAHUN AKTIF
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
   GRAFIK INDIKATOR — BERDASARKAN TAHUN (FINAL)
   ===================================================== */
public function getGrafikIndikatorByTahun($tahunId)
{
    return $this->db->query("
        SELECT
            ik.id AS indikator_id,
            ss.kode_sasaran,
            ss.nama_sasaran,
            ik.kode_indikator,
            ik.nama_indikator,
            ik.mode,

            -- TARGET PK TAHUNAN
            CASE
                WHEN ik.mode = 'akumulatif' THEN ik.target_tw4
                ELSE ik.target_tw1 + ik.target_tw2 + ik.target_tw3 + ik.target_tw4
            END AS target_pk,

            -- REALISASI (AKUMULATIF / NON)
            CASE
                WHEN ik.mode = 'akumulatif' THEN COALESCE(MAX(pk.realisasi), 0)
                ELSE
                    LEAST(COALESCE(SUM(CASE WHEN pk.triwulan = 1 THEN pk.realisasi ELSE 0 END),0), ik.target_tw1)
                  + LEAST(COALESCE(SUM(CASE WHEN pk.triwulan = 2 THEN pk.realisasi ELSE 0 END),0), ik.target_tw2)
                  + LEAST(COALESCE(SUM(CASE WHEN pk.triwulan = 3 THEN pk.realisasi ELSE 0 END),0), ik.target_tw3)
                  + LEAST(COALESCE(SUM(CASE WHEN pk.triwulan = 4 THEN pk.realisasi ELSE 0 END),0), ik.target_tw4)
            END AS realisasi,

            -- PROGRES (%)
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
        JOIN sasaran_strategis ss ON ss.id = ik.sasaran_id
        LEFT JOIN pengukuran_kinerja pk ON pk.indikator_id = ik.id

        WHERE ss.tahun_id = ?

        GROUP BY ik.id
        ORDER BY ss.kode_sasaran ASC, ik.kode_indikator ASC
    ", [$tahunId])->getResultArray();
}


    /* =====================================================
       STEP 4 — GRAFIK TRIWULAN
       ===================================================== */
    public function getGrafikTriwulan($indikatorId)
    {
        $indikator = $this->db->table('indikator_kinerja ik')
    ->select('ik.id, ik.sasaran_id, ik.nama_indikator, ik.mode, ik.target_tw1, ik.target_tw2, ik.target_tw3, ik.target_tw4, ss.tahun_id')
    ->join('sasaran_strategis ss', 'ss.id = ik.sasaran_id')
    ->where('ik.id', $indikatorId)
    ->get()
    ->getRowArray();


        if (!$indikator) return null;

        // REALISASI PER PIC
        $rows = $this->db->table('pengukuran_kinerja pk')
            ->select('pk.user_id, u.nama, pk.triwulan, pk.realisasi')
            ->join('users u', 'u.id = pk.user_id')
            ->where('pk.indikator_id', $indikatorId)
            ->orderBy('pk.triwulan', 'ASC')
            ->get()
            ->getResultArray();

        $realisasiPIC = [];
        foreach ($rows as $r) {
            $uid = $r['user_id'];
            if (!isset($realisasiPIC[$uid])) {
                $realisasiPIC[$uid] = [
                    'nama' => $r['nama'],
                    'data' => [1 => 0, 2 => 0, 3 => 0, 4 => 0]
                ];
            }
            $realisasiPIC[$uid]['data'][$r['triwulan']] += (float)$r['realisasi'];
        }

        // TOTAL REALISASI PER TW
        $totalRealisasiTW = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
        foreach ($realisasiPIC as $pic) {
            foreach ($pic['data'] as $tw => $nilai) {
                $totalRealisasiTW[$tw] += $nilai;
            }
        }

        $targetTW = [
            1 => (float)$indikator['target_tw1'],
            2 => (float)$indikator['target_tw2'],
            3 => (float)$indikator['target_tw3'],
            4 => (float)$indikator['target_tw4'],
        ];

        // PROGRES PER TW
        $progresTW = [];
        if ($indikator['mode'] === 'akumulatif') {
            $targetKumulatif = 0;
            $realisasiKumulatif = 0;
            for ($tw = 1; $tw <= 4; $tw++) {
                $targetKumulatif += $targetTW[$tw];
                $realisasiKumulatif += $totalRealisasiTW[$tw];
                $progresTW[$tw] = $targetKumulatif > 0
                    ? min(($realisasiKumulatif / $targetKumulatif) * 100, 100)
                    : 0;
            }
        } else {
            for ($tw = 1; $tw <= 4; $tw++) {
                $progresTW[$tw] = $targetTW[$tw] > 0
                    ? min(($totalRealisasiTW[$tw] / $targetTW[$tw]) * 100, 100)
                    : 0;
            }
        }

        return [
            'indikator' => $indikator,
            'sasaranId' => $indikator['sasaran_id'],
            'target' => $targetTW,
            'realisasi' => $realisasiPIC,
            'totalRealisasi' => $totalRealisasiTW,
            'progres' => $progresTW,
            'mode' => $indikator['mode']
        ];
    }
}
