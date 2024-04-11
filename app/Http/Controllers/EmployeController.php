<?php

namespace Controllers;

use Models\UtilisateursModel;
use Utils\Controller;

class EmployeController extends Controller
{
    public function index()
    {
        $model = new UtilisateursModel();
        $utilisateurs = $model->all();
        $count = $model->query()->count()->get();

        $data = [
            'utilisateurs'=> $utilisateurs,
            'count' => $count
        ];

        $this->view('dashboard/employe', $data);
    }
}