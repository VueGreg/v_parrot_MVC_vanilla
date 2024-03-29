<?php

namespace Controllers;

use Models\ReparationsModel;

class RepairController extends Controller
{
    public function index()
    {
        $reparations = new ReparationsModel();
        $data['prestations'] = $reparations->getAllData();
        $data['categories'] = $reparations->getCategories();

        $this->view('vitrine/reparations', $data);
    }
}