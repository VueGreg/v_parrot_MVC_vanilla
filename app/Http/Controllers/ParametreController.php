<?php

namespace Controllers;

use Utils\Controller;

class ParametreController extends Controller
{
    public function index()
    {
        $this->view('dashboard/parametre');
    }
}