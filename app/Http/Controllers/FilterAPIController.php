<?php

namespace Controllers;

use Models\AnnoncesModel;
use Models\EnergiesModel;
use Models\VehiculesModel;

use app\Utils\QueryBuilder;

class FilterAPIController extends Controller
{
    public function filter($params)
    {
        if (!empty($params) && isset($params['mark'])) {

            $models = new AnnoncesModel();

            $data = $models ->query()->select('vehicules.modele AS modele')
                            ->join('vehicules', 'annonces.id_vehicules', '=', 'vehicules.id')
                            ->where("vehicules.marque", "LIKE" ,"{$params['mark']}")
                            ->where("annonces.status", "=" , "0")
                            ->get();

            $this->renderApi($data);
        } else {
            $this->renderApi(['error' => 'Missing or invalid parameters']);
        }
    }

    public function getAll()
    {
            $vehicules = new AnnoncesModel();
            $data['minYear'] = $vehicules->query()->min('annee')->where("annonces.status", "=" ,"0")->get();
            $data['maxYear'] = $vehicules->query()->max('annee')->where("annonces.status", "=" ,"0")->get();
            $data['minKilometer'] = $vehicules->query()->min('kilometrage')->where("annonces.status", "=" ,"0")->get();
            $data['maxKilometer'] = $vehicules->query()->max('kilometrage')->where("annonces.status", "=" ,"0")->get();
            $data['minPrice'] = $vehicules->query()->min('prix')->where("annonces.status", "=" ,"0")->get();
            $data['maxPrice'] = $vehicules->query()->max('prix')->where("annonces.status", "=" ,"0")->get();

            $vehiculeModel = new VehiculesModel();
            $data['marqueDispo'] = $vehiculeModel->belongsToMarkAnnonces();
            $data['modeleDispo'] = $vehiculeModel->belongsToModelAnnonces();

            $vehiculeEnergy = new EnergiesModel();
            $data['energieDispo'] = $vehiculeEnergy->belongsToAnnonces();

            $this->renderApi($data);
    }
}