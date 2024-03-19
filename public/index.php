<?php

require '../vendor/autoload.php';

use Router\Router;

$router = new Router();

$router->get('/', ["Controllers\VehicleController", "index"]);

$router->get('/home', ["Controllers\HomeController", 'index']);