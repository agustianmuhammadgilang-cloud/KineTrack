<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentRequestModel extends Model
{
    protected $table            = 'document_requests';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'document_id',
        'requester_id',
        'owner_id',
        'reason',
        'attachment',
        'status',
        'note',
        'is_seen_by_requester',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ambil semua request milik pemilik dokumen (owner)
     */
    public function getRequestsForOwner($ownerId)
    {
        return $this->where('owner_id', $ownerId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Ambil semua request yang diajukan user
     */
    public function getRequestsByRequester($userId)
    {
        return $this->where('requester_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Update status request (approve / reject)
     */
    public function updateStatus($requestId, $status, $note = null)
    {
        $data = ['status' => $status];

        if ($status === 'rejected') {
            $data['note'] = $note;
        }

        return $this->update($requestId, $data);
    }

    /**
     * 🔥 Tandai status request sebagai sudah dilihat oleh requester
     */
    public function markSeenByRequester($userId)
    {
        return $this->where('requester_id', $userId)
            ->whereIn('status', ['approved', 'rejected'])
            ->where('is_seen_by_requester', 0)
            ->set(['is_seen_by_requester' => 1])
            ->update();
    }

    /**
     * 🔴 Hitung badge Status Saya (yang belum dilihat)
     */
    public function countUnseenStatus($userId)
    {
        return $this->where('requester_id', $userId)
            ->whereIn('status', ['approved', 'rejected'])
            ->where('is_seen_by_requester', 0)
            ->countAllResults();
    }
}
