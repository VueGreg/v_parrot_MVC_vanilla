<?php

namespace Controllers;

use Models\ReparationsModel;

class RepairController extends Controller
{
    public function index()
    {
        $reparations = new ReparationsModel();
        $data['prestations'] = $reparations::all();
        $data['categories'] = $reparations::distinct('categorie');

        $this->view('vitrine/reparations', $data);
    }
}