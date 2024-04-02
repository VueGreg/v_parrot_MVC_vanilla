<?php

namespace Controllers;

use Models\AnnoncesModel;

class VehiculeController extends Controller
{
    public function index()
    {
        $vehicules = new AnnoncesModel();
        $data = $vehicules->has(['energies', 'vehicules'], true)->hasMany('images', 'galeries', 'numero_annonce', false, 1);

        $this->view('vitrine/vehicules', $data);
    }
}