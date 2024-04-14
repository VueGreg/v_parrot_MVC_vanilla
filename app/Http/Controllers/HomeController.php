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
        $json['horaires'] = $changeHoraire; //$newHoraires->changeHoraire($changeHoraire);

        $entreprise = new EntrepriseModel();
        $json['informations'] = $entreprise->all();

        $temoignages = new TemoignagesModel();
        $json['temoignages'] = $temoignages->all();

        $annonces = new AnnoncesModel();
        $json['nombre_vehicules'] = $annonces->query()->count()->where("status", "=" , 0)->get();
        $json['dernier_vehicules'] = $annonces->query()
                                    ->queryManual(" SELECT annonces.*, images.adresse AS photo, vehicules.modele, vehicules.marque
                                                    FROM annonces
                                                    INNER JOIN (
                                                        SELECT id_annonces, MIN(id_images) AS id_images
                                                        FROM galeries
                                                        GROUP BY id_annonces
                                                    ) AS galeries ON annonces.id = galeries.id_annonces
                                                    INNER JOIN images ON galeries.id_images = images.id
                                                    INNER JOIN vehicules ON vehicules.id = annonces.id_vehicules
                                                    LIMIT 3")->get();

        $reparations = new ReparationsModel();
        $json['prestations'] = $reparations->all();
        $json['categories'] = $reparations->query()->distinct('categorie')->get();

        $this->view('vitrine/vitrine', $json, true);
    }
}