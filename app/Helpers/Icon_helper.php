<?php 

function heroicons_outline($name) {
    $path = [
        'users' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5m-5 0a3 3 0 11-6 0m6 0a3 3 0 01-6 0m-6 0h5m-5 0a3 3 0 106 0m-6 0a3 3 0 006 0m6-10a4 4 0 11-8 0 4 4 0 018 0z"/>',
        'user' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.034a8.25 8.25 0 1115 0"/>',
        'folder' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5V6a1.5 1.5 0 011.5-1.5h4.379a1.5 1.5 0 011.06.44l1.121 1.121a1.5 1.5 0 001.06.439H19.5A1.5 1.5 0 0121 7.5v9A1.5 1.5 0 0119.5 18h-15A1.5 1.5 0 013 16.5v-9z"/>',
        'trophy' => '<path stroke-linecap="round" stroke-linejoin="round" d="M16 3H8v2a4 4 0 004 4 4 4 0 004-4V3zm-4 6v9"/>',
        'chart-bar' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M9 17V9m4 8V5m4 12v-6"/>'
    ];

    return $path[$name] ?? '';
}
