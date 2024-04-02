<?php

namespace Controllers;

use Models\AnnoncesModel;
use Models\VehiculesModel;

class VehiculeController extends Controller
{
    public function index()
    {
        $vehicules = new AnnoncesModel();
        $data['annonces'] = $vehicules->has(['energies', 'vehicules'], true)->hasMany('images', 'galeries', false, 1);
        $data['minYear'] = $vehicules->min('annee')->where("annonces.status = '0'")->get();
        $data['maxYear'] = $vehicules->max('annee')->where("annonces.status = '0'")->get();
        $data['minKilometer'] = $vehicules->min('kilometrage')->where("annonces.status = '0'")->get();
        $data['maxKilometer'] = $vehicules->max('kilometrage')->where("annonces.status = '0'")->get();
        $data['minPrice'] = $vehicules->min('prix')->where("annonces.status = '0'")->get();
        $data['maxPrice'] = $vehicules->max('prix')->where("annonces.status = '0'")->get();

        $vehiculeModel = new VehiculesModel();
        $data['marqueDispo'] = $vehiculeModel->belongsTo('annonces', 'marque');
        $data['modeleDispo'] = $vehiculeModel->belongsTo('annonces', 'modele');

        $this->view('vitrine/vehicules', $data);
    }
}