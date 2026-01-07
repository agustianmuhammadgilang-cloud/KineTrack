<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PicModel;

class BadgeController extends BaseController
{
    /**
     * Badge merah: Isi Pengukuran Kinerja
     * Berlaku untuk STAFF & ATASAN
     */
    public function pengukuran()
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return $this->response->setJSON(['show' => false]);
        }

        $picModel = new PicModel();

        $hasBadge = $picModel
            ->where('user_id', $userId)
            ->where('is_viewed_by_staff', 0)
            ->countAllResults() > 0;

        return $this->response->setJSON([
            'show' => $hasBadge
        ]);
    }
}
