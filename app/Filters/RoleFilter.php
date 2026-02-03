<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $userRole = session('role');

        // Kalau belum login
        if (!$userRole) {
            return redirect()->to('/login');
        }

        // Kalau role tidak sesuai
        if ($arguments && !in_array($userRole, $arguments)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // kosong
    }
}
