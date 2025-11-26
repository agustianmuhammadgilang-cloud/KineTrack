<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NotificationModel;
use App\Models\UserModel;

class Notifications extends BaseController
{
    protected $notifModel;
    protected $userModel;

    public function __construct()
    {
        $this->notifModel = new NotificationModel();
        $this->userModel  = new UserModel();
    }

    // GET json { count: n }
    public function unreadCount()
    {
        $userId = session('user_id');
        if (!$userId) return $this->response->setJSON(['count'=>0]);

        $count = $this->notifModel
            ->where('user_id', $userId)
            ->where('status', 'unread')
            ->countAllResults();

        return $this->response->setJSON(['count' => (int)$count]);
    }

    // GET list terbaru (default latest 10)
    public function list($limit = 10)
    {
        $userId = session('user_id');
        if (!$userId) return $this->response->setJSON([]);

        $list = $this->notifModel
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit((int)$limit)
            ->findAll();

        return $this->response->setJSON($list);
    }

    // POST mark single read: /notifications/mark/(:num)
    public function markRead($id)
    {
        $userId = session('user_id');
        $n = $this->notifModel->find($id);
        if (!$n || $n['user_id'] != $userId) {
            return $this->response->setStatusCode(404)->setBody('Not found');
        }

        $this->notifModel->update($id, ['status' => 'read']);
        return $this->response->setJSON(['ok' => true]);
    }

    // POST mark all read
    public function markAllRead()
    {
        $userId = session('user_id');
        $this->notifModel
            ->where('user_id', $userId)
            ->where('status', 'unread')
            ->set(['status' => 'read'])
            ->update();
        return $this->response->setJSON(['ok' => true]);
    }


    public function pendingTaskCount()
{
    $userId = session('user_id');
    if (!$userId) return $this->response->setJSON(['count'=>0]);

    $picModel = new \App\Models\PicModel();
    $pengukuran = new \App\Models\PengukuranModel();

    $tasks = $picModel->getTasksForUser($userId);
    $pending = 0;
    foreach ($tasks as $t) {
        $cek = $pengukuran->where('indikator_id', $t['indikator_id'])
                          ->where('user_id', $userId)
                          ->first();
        if (!$cek) $pending++;
    }
    return $this->response->setJSON(['count' => (int)$pending]);
}

}
