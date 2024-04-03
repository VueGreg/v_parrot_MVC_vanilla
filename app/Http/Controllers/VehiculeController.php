<?php

namespace Controllers;

use Models\AnnoncesModel;
use Models\VehiculesModel;

class VehiculeController extends Controller
{
    public function index()
    {
        $vehicules = new AnnoncesModel();
        $data['annonces'] = $vehicules->getAllAnnonces();

        $this->view('vitrine/vehicules', $data);
    }
}