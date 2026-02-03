<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentAccessModel extends Model
{
    protected $table            = 'document_access';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'document_id',
        'user_id',
        'granted_by',
        'granted_at',
    ];

    protected $useTimestamps = false;

    /**
     * Cek apakah user punya akses ke dokumen
     */
    public function hasAccess($documentId, $userId)
    {
        return $this->where([
            'document_id' => $documentId,
            'user_id'     => $userId,
        ])->first();
    }

    /**
     * Berikan akses ke user
     */
    public function grantAccess($documentId, $userId, $grantedBy)
    {
        return $this->insert([
            'document_id' => $documentId,
            'user_id'     => $userId,
            'granted_by'  => $grantedBy,
            'granted_at'  => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Ambil semua dokumen yang bisa diakses user
     */
    public function getAccessibleDocuments($userId)
    {
        return $this->where('user_id', $userId)->findAll();
    }
}