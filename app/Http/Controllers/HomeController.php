<?php

namespace Controllers;

use Models\ReparationsModel;

class HomeController extends Controller
{
    public function index()
    {
        $reparations = new ReparationsModel();
        echo $this->renderApi($reparations->getAllData());
    }
}