<?php

require_once '../vendor/autoload.php';

use Router\Router;

$router = new Router();

// Route site vitrine
$router->get('/', ["Controllers\HomeController", "index"]);
$router->post('/message', ["Controllers\MessageController", 'store']);

//Login
$router->get('/connexion', ["Controllers\UtilisateurController", 'index']);
$router->get('/deconnexion', ["Controllers\UtilisateurController", 'logout']);
$router->post('/connexion', ["Controllers\UtilisateurController", 'login']);

//Route Dashboard 
$router->get('/dashboard/parametre', ["Controllers\ParametreController", 'index'])->auth();

//Route API
$router->get('/filtre', ["Controllers\FilterAPIController", "getAll"]);
$router->get('/filtre/params', ["Controllers\FilterAPIController", "filter"]);

//Call route
return $router->dispatch();
