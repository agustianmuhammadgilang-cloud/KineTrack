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
        'catatan'
    ];

    protected $useTimestamps = true;

    /**
     * ============================
     * DOKUMEN MILIK STAFF
     * ============================
     */
    public function getByStaff($userId)
    {
        return $this->where('created_by', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * ============================
     * DOKUMEN MASUK KAPRODI
     * ============================
     */
    public function getPendingKaprodi($prodiId)
    {
        return $this->where('status', 'pending_kaprodi')
                    ->where('unit_asal_id', $prodiId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * ============================
     * DOKUMEN MASUK KAJUR
     * ============================
     */
    public function getPendingKajur($jurusanId)
    {
        return $this->where('status', 'pending_kajur')
                    ->where('unit_jurusan_id', $jurusanId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * ============================
     * APPROVE OLEH KAPRODI
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
     * APPROVE OLEH KAJUR
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

        if ($dokumen['status'] === 'pending_kaprodi') {
            $status = 'rejected_kaprodi';
        }
        elseif ($dokumen['status'] === 'pending_kajur') {
            $status = 'rejected_kajur';
        }
        else {
            return false;
        }

        return $this->update($dokumenId, [
            'status'           => $status,
            'current_reviewer' => null,
            'catatan'          => $catatan
        ]);
    }
}
