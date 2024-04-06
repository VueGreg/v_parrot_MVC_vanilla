<?php

namespace Controllers;

use Utils\Controller;


class _404Controller extends Controller
{
    public function index()
    {
        $this->view('_404');
    }
}