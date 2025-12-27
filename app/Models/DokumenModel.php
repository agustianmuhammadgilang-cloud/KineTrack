<?php

namespace App\Models;

use CodeIgniter\Model;

class DokumenModel extends Model
{
    protected $table      = 'dokumen_kinerja';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'judul',
        'deskripsi',
        'file_path',
        'created_by',
        'unit_asal_id',
        'unit_jurusan_id',
        'status',
        'current_reviewer',
        'catatan',
        'kategori_id',
        'scope',
        'published_at'
    ];

    protected $useTimestamps = true;

    /**
     * =========================================
     * BASE QUERY (SESUAI STRUKTUR DATABASE)
     * =========================================
     */
    private function baseSelect()
{
    return $this->select([
            'dokumen_kinerja.*',
            'users.nama                     AS nama_pengirim',
            'jabatan.nama_jabatan           AS nama_jabatan',
            'bidang.nama_bidang             AS nama_unit',
            'kategori_dokumen.nama_kategori AS nama_kategori'
        ])
        ->join('users', 'users.id = dokumen_kinerja.created_by')
        ->join('jabatan', 'jabatan.id = users.jabatan_id', 'left')
        ->join('bidang', 'bidang.id = users.bidang_id', 'left')
        // 🔥 INI KUNCI NYA
        ->join('kategori_dokumen', 'kategori_dokumen.id = dokumen_kinerja.kategori_id', 'left');
}


    /**
     * ============================
     * DOKUMEN MILIK STAFF
     * ============================
     */
    public function getByStaff($userId)
    {
        return $this->baseSelect()
            ->where('dokumen_kinerja.created_by', $userId)
            ->orderBy('dokumen_kinerja.created_at', 'DESC')
            ->findAll();
    }

    /**
     * ============================
     * DOKUMEN UNIT (STAFF & ATASAN)
     * ============================
     */
    public function getDokumenUnit($unitId)
{
    return $this->baseSelect()
        ->where('dokumen_kinerja.scope', 'unit')
        ->groupStart()
            ->where('dokumen_kinerja.unit_asal_id', $unitId)
            ->orWhere('dokumen_kinerja.unit_jurusan_id', $unitId)
        ->groupEnd()
        ->whereIn('dokumen_kinerja.status', [
            'pending_kaprodi',
            'pending_kajur',
            'archived'
        ])
        ->orderBy('dokumen_kinerja.created_at', 'DESC')
        ->findAll();
}


    /**
     * ============================
     * DOKUMEN PUBLIK
     * ============================
     */
    public function getDokumenPublic()
    {
        return $this->baseSelect()
            ->where('dokumen_kinerja.scope', 'public')
            ->where('dokumen_kinerja.status', 'archived')
            ->orderBy('dokumen_kinerja.created_at', 'DESC')
            ->findAll();
    }

    /**
     * ============================
     * DOKUMEN MASUK KAPRODI
     * ============================
     */
    public function getPendingKaprodi($prodiId)
    {
        return $this->baseSelect()
            ->where('dokumen_kinerja.status', 'pending_kaprodi')
            ->where('dokumen_kinerja.unit_asal_id', $prodiId)
            ->orderBy('dokumen_kinerja.created_at', 'DESC')
            ->findAll();
    }

    /**
     * ============================
     * DOKUMEN MASUK KAJUR
     * ============================
     */
    public function getPendingKajur($jurusanId)
    {
        return $this->baseSelect()
            ->where('dokumen_kinerja.status', 'pending_kajur')
            ->where('dokumen_kinerja.unit_jurusan_id', $jurusanId)
            ->orderBy('dokumen_kinerja.created_at', 'DESC')
            ->findAll();
    }

    /**
     * ============================
     * APPROVE KAPRODI
     * ============================
     */
    public function approveKaprodi($dokumenId)
    {
        $dokumen = $this->find($dokumenId);

        if (!$dokumen || $dokumen['status'] !== 'pending_kaprodi') {
            return false;
        }

        return $this->update($dokumenId, [
            'status'           => 'pending_kajur',
            'current_reviewer' => 'kajur',
            'catatan'          => null
        ]);
    }

    /**
     * ============================
     * APPROVE KAJUR
     * ============================
     */
    public function approveKajur($dokumenId)
    {
        $dokumen = $this->find($dokumenId);

        if (!$dokumen || $dokumen['status'] !== 'pending_kajur') {
            return false;
        }

        return $this->update($dokumenId, [
            'status'           => 'archived',
            'current_reviewer' => null,
            'catatan'          => null
        ]);
    }

    /**
     * ============================
     * REJECT DOKUMEN
     * ============================
     */
    public function rejectDokumen($dokumenId, $catatan)
    {
        $dokumen = $this->find($dokumenId);

        if (!$dokumen || empty($catatan)) {
            return false;
        }

        $status = match ($dokumen['status']) {
            'pending_kaprodi' => 'rejected_kaprodi',
            'pending_kajur'   => 'rejected_kajur',
            default           => null
        };

        if (!$status) return false;

        return $this->update($dokumenId, [
            'status'           => $status,
            'current_reviewer' => null,
            'catatan'          => $catatan
        ]);
    }
}
