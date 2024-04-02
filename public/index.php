<?php

require_once '../vendor/autoload.php';

use Router\Router;

$router = new Router();

// Route site vitrine
$router->get('/', ["Controllers\HomeController", "index"]);
$router->get('/reparations', ["Controllers\RepairController", 'index']);
$router->get('/vehicules', ["Controllers\VehiculeController", 'index']);

//Route Dashboard 

//Call route
return $router->dispatch();