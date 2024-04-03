<?php

namespace Controllers;

use Models\ReparationsModel;

class RepairController extends Controller
{
    public function index()
    {
        $reparations = new ReparationsModel();
        $data['prestations'] = $reparations->all();
        $data['categories'] = $reparations->query()->distinct('categorie')->get();

        $this->view('vitrine/reparations', $data);
    }
}