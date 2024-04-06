<?php

namespace Controllers;

use Utils\Controller;
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
        $json['images'] = $images->all();

        $horaires = new HorairesModel();
        $changeHoraire = $horaires->all();
        $newHoraires = new ChangeHoraireFormat();
        $json['horaires'] = $newHoraires->changeHoraire($changeHoraire);

        $entreprise = new EntrepriseModel();
        $json['informations'] = $entreprise->all();

        $temoignages = new TemoignagesModel();
        $json['temoignages'] = $temoignages->all();

        $annonces = new AnnoncesModel();
        $json['nombre_vehicules'] = $annonces->query()->count()->where("status", "=" , 0)->get();

        $reparations = new ReparationsModel();
        $json['prestations'] = $reparations->all();
        $json['categories'] = $reparations->query()->distinct('categorie')->get();

        $vehicules = new AnnoncesModel();
        $json['annonces'] = $vehicules->getAllAnnonces();

        $this->view('vitrine/vitrine', $json, true);
    }
}