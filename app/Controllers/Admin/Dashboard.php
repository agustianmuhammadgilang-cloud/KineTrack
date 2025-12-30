<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\JabatanModel;
use App\Models\BidangModel;
use App\Models\NotificationModel;
// Controller untuk menampilkan dashboard admin
class Dashboard extends BaseController
{
    protected $notifModel;

    public function __construct()
    {
        $this->notifModel = new NotificationModel();
    }
// Menampilkan halaman dashboard
    public function index()
    {
        $user    = new UserModel();
        $jabatan = new JabatanModel();
        $bidang  = new BidangModel();

        $userId = session('user_id');

        // Ambil notifikasi untuk admin
        $notifications = $this->notifModel
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $unreadCount = $this->notifModel
            ->where('user_id', $userId)
            ->where('status', 'unread')
            ->countAllResults();

        $data = [
            'total_user'    => $user->countAllResults(),
            'total_jabatan' => $jabatan->countAllResults(),
            'total_bidang'  => $bidang->countAllResults(),
            'notifications' => $notifications,
            'unreadCount'   => $unreadCount
        ];

        return view('admin/dashboard', $data);
    }

    // AJAX untuk mark as read
    public function markRead($id)
    {
        $this->notifModel->update($id, ['status' => 'read']);
        return $this->response->setJSON(['success' => true]);
    }
}