<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NotificationModel;

class Notifications extends BaseController
{
    protected $notif;

    public function __construct()
    {
        $this->notif = new NotificationModel();
    }

    // ========================================================
    // 1. Jumlah notifikasi BELUM dibaca
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
    // 2. List notifikasi terbaru
    // ========================================================
    public function list($limit = 10)
    {
        $userId = session('user_id');
        if (!$userId) return $this->response->setJSON([]);

        $data = $this->notif
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->limit((int)$limit)
            ->find();

        return $this->response->setJSON($data);
    }

    // ========================================================
    // 3. Tandai satu notifikasi sebagai read
    // ========================================================
    public function markRead($id)
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
    // 4. Tandai semua sebagai read
    // ========================================================
    public function markAllRead()
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
    // 5. Notifikasi terbaru (1 item) — untuk toast
    // ========================================================
    public function latest()
    {
        $userId = session('user_id');
        if (!$userId) return $this->response->setJSON([]);

        $n = $this->notif
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->first();

        return $this->response->setJSON($n ?? []);
    }
}
