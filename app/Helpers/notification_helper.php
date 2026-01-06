<?php

use App\Models\BidangModel;
use App\Models\UserModel;

if (!function_exists('get_atasan_id')) {
    /**
     * Ambil user_id atasan (kaprodi / kajur) berdasarkan bidang staff
     *
     * @param int $bidangId
     * @return int|null
     */
    function get_atasan_id($bidangId)
    {
        if (!$bidangId) {
            return null;
        }

        $bidangModel = new BidangModel();
        $userModel   = new UserModel();

        $bidang = $bidangModel->find($bidangId);

        if (!$bidang) {
            return null;
        }

        /**
         * ============================
         * STAFF DI PRODI
         * parent_id != null → atasan = KAPRODI (bidang = prodi)
         * ============================
         */
        if ($bidang['parent_id'] !== null) {
            $atasan = $userModel
                ->where('role', 'kaprodi')
                ->where('bidang_id', $bidang['id'])
                ->first();

            return $atasan['id'] ?? null;
        }

        /**
         * ============================
         * STAFF DI JURUSAN
         * parent_id == null → atasan = KAJUR
         * ============================
         */
        $atasan = $userModel
            ->where('role', 'kajur')
            ->where('bidang_id', $bidang['id'])
            ->first();

        return $atasan['id'] ?? null;
    }
}
