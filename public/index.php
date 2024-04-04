<?php

require_once '../vendor/autoload.php';

use Router\Router;

$router = new Router();

// Route site vitrine
$router->get('/', ["Controllers\HomeController", "index"]);
$router->get('/reparations', ["Controllers\RepairController", 'index']);
$router->get('/vehicules', ["Controllers\VehiculeController", 'index']);
$router->get('/contact', ["Controllers\ContactController", 'index']);

//Route Dashboard 

//Route API
$router->get('/filtre', ["Controllers\FilterAPIController", "getAll"]);
$router->get('/filtre/params', ["Controllers\FilterAPIController", "filter"]);

//Call route
return $router->dispatch();
