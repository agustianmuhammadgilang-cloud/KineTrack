<?php

namespace App\Controllers;

// Controller untuk halaman landing
class Landing extends BaseController
{
    public function index(): string
    {
        return view('landing/index');
    }
}
