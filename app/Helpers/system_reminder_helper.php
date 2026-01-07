<?php

if (!function_exists('system_reminder')) {

    function system_reminder(
        string $actionType,
        string $message,
        string $relatedTable = null,
        int $totalData = 0,
        string $status = 'success'
    ) {
        return db_connect()
            ->table('system_reminders')
            ->insert([
                'action_type'   => $actionType,
                'message'       => $message,
                'related_table' => $relatedTable,
                'total_data'    => $totalData,
                'status'        => $status,
                'executed_at'   => date('Y-m-d H:i:s'),
                'created_at'    => date('Y-m-d H:i:s'),
            ]);
    }
}