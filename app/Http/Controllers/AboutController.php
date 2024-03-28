<?php

namespace Controllers;

use Models\ImagesModel;

class AboutController extends Controller
{
    public function index()
    {
        $images = new ImagesModel();
        $data = $images->getAllData();

        $this->view('vitrine/about', $data);
    }
}