<?php

namespace App\Controllers;

class Landing extends BaseController
{
    public function index(): string
    {
        return view('landing/index');
    }
}
