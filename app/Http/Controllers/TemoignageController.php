<?php

namespace Controllers;

use Models\TemoignagesModel;
use Utils\Controller;

class TemoignageController extends Controller
{
    public function index()
    {
        $model = new TemoignagesModel();
        $temoignages_publie = $model->query()->select()->where('etat', "=", 1)->get();
        $temoignages_attente = $model->query()->select()->where('etat', "=", 0)->get();
        
        $count_publie = $model->query()->count()->where('etat', "=", 1)->get();
        $count_attente = $model->query()->count()->where('etat', "=", 0)->get();

        $data = [
            'temoignages_publie' => $temoignages_publie,
            'temoignages_attente' => $temoignages_attente,
            'count_publie' => $count_publie,
            'count_attente' => $count_attente
        ];

        $this->view('dashboard/temoignage', $data);
    }
}