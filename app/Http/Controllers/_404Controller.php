<?php

namespace Controllers;


class _404Controller extends Controller
{
    public function index()
    {
        $this->view('vitrine/_404');
    }
}