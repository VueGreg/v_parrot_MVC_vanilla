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
        $json['images'] =  $images::all();

        $horaires = new HorairesModel();
        $changeHoraire = $horaires::all();
        $newHoraires = new ChangeHoraireFormat();
        $json['horaires'] = $newHoraires->changeHoraire($changeHoraire);

        $entreprise = new EntrepriseModel();
        $json['informations'] = $entreprise::all();

        $temoignages = new TemoignagesModel();
        $json['temoignages'] = $temoignages::all();

        $annonces = new AnnoncesModel();
        $json['nombre_vehicules'] = $this->countData($annonces::where("status = 0"));

        $this->view('vitrine/acceuil', $json);
    }
}