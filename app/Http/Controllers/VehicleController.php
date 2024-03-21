<?php

namespace Controllers;

class VehicleController extends Controller
{
    public function index()
    {
        $this->view("VehicleView");
    }
}