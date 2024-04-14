<?php

namespace Controllers;

use Models\AnnoncesModel;
use Utils\Controller;

class AnnonceController extends Controller
{
    public function show($params)
    {
        $vehicules = (new AnnoncesModel())->getAllAnnonces();
        
        foreach ($vehicules as $vehicule) {
            if ($vehicule['slug'] == $params['slug']) {
                $this->renderApi($vehicule);
            }
        }
    }
}