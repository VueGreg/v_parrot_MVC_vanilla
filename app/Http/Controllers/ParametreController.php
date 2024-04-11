<?php

namespace Controllers;

use Models\EntrepriseModel;
use Models\HorairesModel;
use Models\ReparationsModel;
use Utils\Controller;

class ParametreController extends Controller
{
    public function index()
    {
        $horaires = (new HorairesModel())->all();
        $informations = (new EntrepriseModel())->all();
        $reparations = (new ReparationsModel())->all();

        $data = [
            'horaires'=> $horaires,
            'informations' => $informations,
            'reparations' => $reparations
        ];

        $this->view('dashboard/parametre', $data);
    }
}