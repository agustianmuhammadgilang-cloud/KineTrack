<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AutoTwFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('tw');
        autoUnlockTW(); // 🔑 SINKRONISASI DB
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // no-op
    }
}
