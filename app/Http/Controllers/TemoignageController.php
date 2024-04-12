<?php

namespace Controllers;

use Utils\Request;
use Utils\Controller;
use Models\TemoignagesModel;

class TemoignageController extends Controller
{
    public function index()
    {
        $data = $this->getTemoignage();
        $this->view('dashboard/temoignage', $data);
    }

    public function update(Request $request)
    {
        header('Content-Type: application/json');

        $model = new TemoignagesModel();
        $temoignages = $model->all();
        $id = $request->getPost();

        foreach ($temoignages as $temoignage) {
            if ($temoignage->id == $id) {
                $newState = $temoignage->etat == 0 ? 1 : 0;
                if ($temoignage->query()->update(['etat' => $newState], $id)) {
                    $result = $this->getTemoignage();
                    echo json_encode($result);
                    return;
                }
            }
        }

        $error = 'Une erreur s\'est produite lors de la mise à jour';
        echo json_encode($error);
    }

    public function delete(Request $request)
    {
        header('Content-Type: application/json');

        $model = new TemoignagesModel();
        $temoignages = $model->all();
        $id = $request->getParams()['id'];

        foreach ($temoignages as $temoignage) {
            if ($temoignage->id == $id && $model->query()->delete($id)) {
                $result = $this->getTemoignage();
                echo json_encode($result);
                return;
            }
        }

        $error = 'Une erreur s\'est produite lors de la mise à jour';
        echo json_encode($error);
    }

    private function getTemoignage(): Array
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

        return $data;
    }


}