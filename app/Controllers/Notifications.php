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
    // Jumlah notifikasi BELUM dibaca
    // ========================================================
    public function unreadCount()
    {
        $userId = session('user_id');
        if (!$userId) {
            return $this->response->setJSON(['count' => 0]);
        }

        $count = $this->notif
            ->where('user_id', $userId)
            ->where('status', 'unread')
            ->countAllResults();

        return $this->response->setJSON(['count' => (int) $count]);
    }

    // ========================================================
    // List notifikasi
    // ========================================================
    public function list($limit = 10)
    {
        $userId = session('user_id');
        if (!$userId) {
            return $this->response->setJSON([]);
        }

        $role = session('role'); // admin / staff / atasan

        $data = $this->notif
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->limit((int) $limit)
            ->findAll();

        foreach ($data as &$row) {
            $row['url'] = '#';

            if (!empty($row['meta'])) {
                $m = json_decode($row['meta'], true);

                if (!empty($m['pengukuran_id'])) {
                    // Tentukan URL berdasarkan ROLE
                    if ($role === 'admin') {
                        $row['url'] = base_url("admin/pengukuran/detail/" . $m['pengukuran_id']);
                    } elseif ($role === 'staff') {
                        $row['url'] = base_url("staff/pengukuran");
                    } elseif ($role === 'atasan') {
                        $row['url'] = base_url("atasan/pengukuran");
                    }
                }
            }
        }

        return $this->response->setJSON($data);
    }

    // ========================================================
    // Tandai satu notifikasi sebagai read
    // ========================================================
    public function mark($id)
    {
        $userId = session('user_id');
        if (!$userId) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON(['error' => 'Unauthenticated']);
        }

        $notif = $this->notif->find($id);
        if (!$notif || $notif['user_id'] != $userId) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON(['error' => 'Not found']);
        }

        $this->notif->update($id, ['status' => 'read']);

        return $this->response->setJSON(['ok' => true]);
    }

    // ========================================================
    // Tandai semua sebagai read
    // ========================================================
    public function markAll()
    {
        $userId = session('user_id');
        if (!$userId) {
            return $this->response->setJSON(['ok' => false]);
        }

        $this->notif
            ->where('user_id', $userId)
            ->where('status', 'unread')
            ->set(['status' => 'read'])
            ->update();

        return $this->response->setJSON(['ok' => true]);
    }

    // ========================================================
    // Notifikasi terbaru (TOAST)
    // ========================================================
    public function latest()
    {
        $userId = session('user_id');
        if (!$userId) {
            return $this->response->setJSON([]);
        }

        $role = session('role');

        $n = $this->notif
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->first();

        if ($n) {
            $n['url'] = '#';

            if (!empty($n['meta'])) {
                $m = json_decode($n['meta'], true);

                if (!empty($m['pengukuran_id'])) {
                    if ($role === 'admin') {
                        $n['url'] = base_url("admin/pengukuran/detail/" . $m['pengukuran_id']);
                    } elseif ($role === 'staff') {
                        $n['url'] = base_url("staff/pengukuran");
                    } elseif ($role === 'atasan') {
                        $n['url'] = base_url("atasan/pengukuran");
                    }
                }
            }
        }

        return $this->response->setJSON($n ?? []);
    }
}
