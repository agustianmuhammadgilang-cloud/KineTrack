<?php

use App\Models\ActivityLogModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\HTTP\CLIRequest;

if (!function_exists('log_activity')) {

    function log_activity(
        string $action,
        string $description,
        string $subjectType = null,
        int $subjectId = null
    ) {
        $session = session();

        if (!$session->has('user_id')) {
            return false;
        }

        $request = service('request');

        /**
         * ================================
         * HANDLE CLI vs WEB
         * ================================
         */
        if ($request instanceof CLIRequest) {
            $ipAddress = 'CLI';
            $userAgent = 'SYSTEM (CLI)';
        } else {
            $ipAddress = $request->getIPAddress();
            $userAgent = $request->getUserAgent()
                ? $request->getUserAgent()->getAgentString()
                : 'UNKNOWN';
        }

        $logModel = new ActivityLogModel();

        return $logModel->insert([
            'user_id'      => $session->get('user_id'),
            'role'         => $session->get('role'),
            'action'       => $action,
            'description'  => $description,
            'subject_type' => $subjectType,
            'subject_id'   => $subjectId,
            'ip_address'   => $ipAddress,
            'user_agent'   => $userAgent,
            'created_at'   => Time::now()->toDateTimeString(),
        ]);
    }
}