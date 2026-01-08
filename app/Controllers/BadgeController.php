<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PicModel;
use App\Models\PengajuanKategoriModel;
use App\Models\DokumenModel;
use App\Models\DokumenViewModel;


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

        return $this->response->setJSON(['show' => $hasBadge]);
    }

    /**
     * Badge merah: Pengajuan Kategori
     * Berlaku untuk ADMIN
     */
    public function pengajuan()
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return $this->response->setJSON(['show' => false, 'count' => 0]);
        }

        $pengajuanModel = new PengajuanKategoriModel();

        $count = $pengajuanModel
            ->where('status', 'pending')
            ->where('is_viewed_by_admin', 0)
            ->countAllResults();

        return $this->response->setJSON([
            'show'  => $count > 0,
            'count' => $count
        ]);
    }

    /**
     * Mark all Pengajuan Kategori as read
     */
    public function markPengajuanRead()
    {
        $pengajuanModel = new PengajuanKategoriModel();

        $pengajuanModel
            ->where('status', 'pending')
            ->where('is_viewed_by_admin', 0)
            ->set('is_viewed_by_admin', 1)
            ->update();

        return $this->response->setJSON(['success' => true]);
    }

    /**
 * Badge merah: Dokumen Kinerja (ATASAN)
 */
public function dokumenKinerja()
{
    $role     = session()->get('role');
    $bidangId = session()->get('bidang_id');
    $userId   = session()->get('user_id');

    if ($role !== 'atasan' || !$bidangId || !$userId) {
        return $this->response->setJSON(['show' => false, 'count' => 0]);
    }

    $dokumenModel = new DokumenModel();
    $viewsModel   = new DokumenViewModel();
    $bidang       = model('BidangModel')->find($bidangId);

    if (!$bidang) {
        return $this->response->setJSON(['show' => false, 'count' => 0]);
    }

    // Ambil dokumen pending sesuai role kaprodi/kajur
    if ($bidang['parent_id'] !== null) {
        $dokumen = $dokumenModel
            ->where('status', 'pending_kaprodi')
            ->where('unit_asal_id', $bidang['id'])
            ->findAll();
    } else {
        $dokumen = $dokumenModel
            ->where('status', 'pending_kajur')
            ->where('unit_jurusan_id', $bidang['id'])
            ->findAll();
    }

    $unread = 0;

    foreach ($dokumen as $d) {
        $exists = $viewsModel
            ->where('dokumen_id', $d['id'])
            ->where('user_id', $userId)
            ->first();
        if (!$exists) {
            $unread++;
        }
    }

    return $this->response->setJSON([
        'show'  => $unread > 0,
        'count' => $unread
    ]);
}

/**
 * Mark Dokumen Kinerja as read (ATASAN)
 */
public function markDokumenRead()
{
    $role     = session()->get('role');
    $bidangId = session()->get('bidang_id');
    $userId   = session()->get('user_id');

    if ($role !== 'atasan' || !$bidangId || !$userId) {
        return $this->response->setJSON(['success' => false]);
    }

    $dokumenModel = new DokumenModel();
    $viewsModel   = new DokumenViewModel();
    $bidang       = model('BidangModel')->find($bidangId);

    if (!$bidang) {
        return $this->response->setJSON(['success' => false]);
    }

    if ($bidang['parent_id'] !== null) {
        $dokumen = $dokumenModel
            ->where('status', 'pending_kaprodi')
            ->where('unit_asal_id', $bidang['id'])
            ->findAll();
    } else {
        $dokumen = $dokumenModel
            ->where('status', 'pending_kajur')
            ->where('unit_jurusan_id', $bidang['id'])
            ->findAll();
    }

    foreach ($dokumen as $d) {
        $viewsModel->markViewed($d['id'], $userId, 'kinerja');
    }

    return $this->response->setJSON(['success' => true]);
}

public function dokumenUnit()
{
    $userId   = session()->get('user_id');
    $bidangId = session()->get('bidang_id');

    if (!$userId || !$bidangId) {
        return $this->response->setJSON(['show' => false]);
    }

    $dokumenModel = new DokumenModel();
    $viewsModel   = new DokumenViewModel();
    $bidang       = model('BidangModel')->find($bidangId);

    // Tentukan jurusan (untuk staff prodi)
    $unitJurusan = $bidang['parent_id'] ?? $bidang['id'];

    $dokumen = $dokumenModel->getDokumenUnit($unitJurusan);

    foreach ($dokumen as $d) {
        $v = $viewsModel
            ->where('dokumen_id', $d['id'])
            ->where('user_id', $userId)
            ->first();

        if (!$v) {
            return $this->response->setJSON(['show' => true]);
        }
    }

    return $this->response->setJSON(['show' => false]);
}

public function dokumenPublic()
{
    $userId = session()->get('user_id');

    if (!$userId) {
        return $this->response->setJSON(['show' => false]);
    }

    $dokumenModel = new DokumenModel();
    $viewsModel   = new DokumenViewModel();

    $dokumen = $dokumenModel->getDokumenPublic();

    foreach ($dokumen as $d) {
        $v = $viewsModel
            ->where('dokumen_id', $d['id'])
            ->where('user_id', $userId)
            ->first();

        if (!$v) {
            return $this->response->setJSON(['show' => true]);
        }
    }

    return $this->response->setJSON(['show' => false]);
}

public function markDokumenUnitRead()
{
    $userId   = session()->get('user_id');
    $bidangId = session()->get('bidang_id');

    if (!$userId || !$bidangId) {
        return $this->response->setJSON(['success' => false]);
    }

    $dokumenModel = new DokumenModel();
    $viewsModel   = new DokumenViewModel();
    $bidang       = model('BidangModel')->find($bidangId);

    $unitJurusan = $bidang['parent_id'] ?? $bidang['id'];

    $dokumen = $dokumenModel->getDokumenUnit($unitJurusan);

    foreach ($dokumen as $d) {
        $viewsModel->insert([
            'dokumen_id' => $d['id'],
            'user_id'    => $userId,
            'viewed_at'  => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
        ], false);
    }

    return $this->response->setJSON(['success' => true]);
}

public function markDokumenPublicRead()
{
    $userId = session()->get('user_id');

    if (!$userId) {
        return $this->response->setJSON(['success' => false]);
    }

    $dokumenModel = new DokumenModel();
    $viewsModel   = new DokumenViewModel();

    $dokumen = $dokumenModel->getDokumenPublic();

    foreach ($dokumen as $d) {
        $viewsModel->insert([
            'dokumen_id' => $d['id'],
            'user_id'    => $userId,
            'viewed_at'  => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
        ], false);
    }

    return $this->response->setJSON(['success' => true]);
}

/**
 * STAFF — Badge Dokumen Unit
 */
public function staffDokumenUnit()
{
    $role     = session()->get('role');
    $bidangId = session()->get('bidang_id');

    if ($role !== 'staff' || !$bidangId) {
        return $this->response->setJSON(['show' => false]);
    }

    $dokumenModel = new DokumenModel();
    $count = $dokumenModel
        ->where('scope', 'unit')
        ->where('unit_asal_id', $bidangId)
        ->where('is_viewed_by_staff', 0)
        ->countAllResults();

    return $this->response->setJSON([
        'show' => $count > 0
    ]);
}

public function markStaffDokumenUnitRead()
{
    $role     = session()->get('role');
    $bidangId = session()->get('bidang_id');

    if ($role !== 'staff' || !$bidangId) {
        return $this->response->setJSON(['success' => false]);
    }

    $dokumenModel = new DokumenModel();
    $dokumenModel
        ->where('scope', 'unit')
        ->where('unit_asal_id', $bidangId)
        ->set('is_viewed_by_staff', 1)
        ->update();

    return $this->response->setJSON(['success' => true]);
}

/**
 * STAFF — Badge Dokumen Public
 */
public function staffDokumenPublic()
{
    if (session()->get('role') !== 'staff') {
        return $this->response->setJSON(['show' => false]);
    }

    $dokumenModel = new DokumenModel();
    $count = $dokumenModel
        ->where('scope', 'public')
        ->where('is_viewed_by_staff', 0)
        ->countAllResults();

    return $this->response->setJSON([
        'show' => $count > 0
    ]);
}

public function markStaffDokumenPublicRead()
{
    if (session()->get('role') !== 'staff') {
        return $this->response->setJSON(['success' => false]);
    }

    $dokumenModel = new DokumenModel();
    $dokumenModel
        ->where('scope', 'public')
        ->set('is_viewed_by_staff', 1)
        ->update();

    return $this->response->setJSON(['success' => true]);
}
}
