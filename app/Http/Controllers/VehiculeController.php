<?php

namespace Controllers;

use Models\AnnoncesModel;

class VehiculeController extends Controller
{
    public function index()
    {
        $vehicules = new AnnoncesModel();
        $data = $vehicules::has(['energies', 'vehicules']);

        $this->view('vitrine/vehicules', $data);
    }
}