<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NotificationModel;

// Controller untuk mengelola notifikasi
class Notifications extends BaseController
{
    protected $notif;

    // Konstruktor untuk inisialisasi model notifikasi
    public function __construct()
    {
        $this->notif = new NotificationModel();
    }

    // ========================================================
    // Jumlah notifikasi BELUM dibaca
    // ========================================================
    public function unreadCount()
    {
        $userId = session('user_id');
        if (!$userId) return $this->response->setJSON(['count' => 0]);

        $count = $this->notif
            ->where('user_id', $userId)
            ->where('status', 'unread')
            ->countAllResults();

        return $this->response->setJSON(['count' => (int)$count]);
    }

    // ========================================================
    // List notifikasi terbaru
    // ========================================================
    public function list($limit = 10)
    {
        $userId = session('user_id');
        if (!$userId) return $this->response->setJSON([]);

        $data = $this->notif
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->limit((int)$limit)
            ->findAll();

        foreach ($data as &$row) {
            $row['url'] = '#';

            if (!empty($row['meta'])) {
                $m = json_decode($row['meta'], true);

                if (!empty($m['pengukuran_id'])) {
                    $row['url'] = base_url("admin/pengukuran/detail/" . $m['pengukuran_id']);
                }
            }
        }

        return $this->response->setJSON($data);
    }

    // ========================================================
    // Tandai satu notifikasi sebagai read
    //    (JS memanggil mark/{id})
    // ========================================================
    public function mark($id)
    {
        $userId = session('user_id');
        if (!$userId) return $this->response->setStatusCode(401)->setBody('Unauthenticated');

        $notif = $this->notif->find($id);
        if (!$notif || $notif['user_id'] != $userId) {
            return $this->response->setStatusCode(404)->setBody('Not found');
        }

        $this->notif->update($id, ['status' => 'read']);

        return $this->response->setJSON(['ok' => true]);
    }

    // ========================================================
    // Tandai semua sebagai read  (JS memanggil mark-all)
    // ========================================================
    public function markAll()
    {
        $userId = session('user_id');

        $this->notif
            ->where('user_id', $userId)
            ->where('status', 'unread')
            ->set(['status' => 'read'])
            ->update();

        return $this->response->setJSON(['ok' => true]);
    }

    // ========================================================
    // Notifikasi terbaru — untuk toast
    // ========================================================
    public function latest()
    {
        $userId = session('user_id');
        if (!$userId) return $this->response->setJSON([]);

        $n = $this->notif
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->first();

        if ($n) {
            $n['url'] = '#';

            if (!empty($n['meta'])) {
                $m = json_decode($n['meta'], true);

                if (!empty($m['pengukuran_id'])) {
                    $n['url'] = base_url("admin/pengukuran/detail/" . $m['pengukuran_id']);
                }
            }
        }

        return $this->response->setJSON($n ?? []);
    }
}
