<?php

use App\Models\ActivityLogModel;
use CodeIgniter\I18n\Time;

// Helper untuk mencatat log aktivitas
if (!function_exists('log_activity')) {
    // Fungsi untuk mencatat log aktivitas
    function log_activity(
        string $action,
        string $description,
        string $subjectType = null,
        int $subjectId = null
    ) {
        // Ambil session
        $session = session();

        // Pastikan ada user yang login
        if (!$session->has('user_id')) {
            return false;
        }
        // Simpan log aktivitas ke database
        $logModel = new ActivityLogModel();

        return $logModel->insert([
            'user_id'      => $session->get('user_id'),
            'role'         => $session->get('role'),
            'action'       => $action,
            'description'  => $description,
            'subject_type' => $subjectType,
            'subject_id'   => $subjectId,
            'ip_address'   => service('request')->getIPAddress(),
            'user_agent'   => service('request')->getUserAgent()->getAgentString(),
            'created_at'   => Time::now()->toDateTimeString(), // WIB
        ]);
    }
}
