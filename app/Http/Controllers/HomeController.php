<?php

namespace Controllers;

use Models\ImagesModel;
use Models\AnnoncesModel;
use Models\HorairesModel;
use Models\EntrepriseModel;
use Models\ReparationsModel;
use Models\TemoignagesModel;
use Actions\ChangeHoraireFormat;

class HomeController extends Controller
{
    public function index()
    {
        $images = new ImagesModel();
        $json['images'] =  $images->getAllData();

        $reparations = new ReparationsModel();
        $json['reparations'] = $reparations->getAllData();
        $json['categorie_reparations'] = $reparations->getCategories();

        
        $horaires = new HorairesModel();
        $changeHoraire = $horaires->getAllData();
        $newHoraires = new ChangeHoraireFormat();
        $json['horaires'] = $newHoraires->changeHoraire($changeHoraire);

        $entreprise = new EntrepriseModel();
        $json['informations'] = $entreprise->getAllData();

        $temoignages = new TemoignagesModel();
        $json['temoignages'] = $temoignages->getAllData();

        $annonces = new AnnoncesModel();
        $json['nombre_vehicules'] = $this->countData($annonces->getDataFromSell());

        $this->view('vitrine/acceuil', $json);
    }
}