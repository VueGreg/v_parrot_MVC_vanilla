<?php

namespace Controllers;

use Utils\Controller;
use Models\AnnoncesModel;
use Models\EnergiesModel;
use Models\VehiculesModel;

class FilterAPIController extends Controller
{
    public function filter($params)
    {
        if (!empty($params) && isset($params['marque'])) {

            $marque = new AnnoncesModel();

            $data = $marque ->query()->select('vehicules.modele AS modele, energies.nom AS energie')
                            ->join('vehicules', 'annonces.id_vehicules', '=', 'vehicules.id')
                            ->join('energies', 'annonces.id_energies', '=', 'energies.id')
                            ->where("vehicules.marque", "LIKE" ,"{$params['marque']}")
                            ->where("annonces.status", "=" , 0)
                            ->get();

            $this->renderApi($data);

        } elseif (!empty($params) && isset($params['modele'])) {

            $modele = new AnnoncesModel();

            $data = $modele ->query()->select('vehicules.marque AS marque, energies.nom AS energie')
                            ->join('vehicules', 'annonces.id_vehicules', '=', 'vehicules.id')
                            ->join('energies', 'annonces.id_energies', '=', 'energies.id')
                            ->where('vehicules.modele', 'LIKE', "{$params['modele']}")
                            ->where("annonces.status", "=" , 0)
                            ->get();

            $this->renderApi($data);
        }
        
        else {
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
            $data['modeleEtMarque'] = $vehiculeModel->belongsToModelMarqueAnnonces();

            $vehiculeEnergy = new EnergiesModel();
            $data['energieDispo'] = $vehiculeEnergy->belongsToAnnonces();

            $this->renderApi($data);
    }
}