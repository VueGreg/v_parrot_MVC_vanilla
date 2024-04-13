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
$router->get('/isconnect', ["Controllers\UtilisateurController", 'isConnect']);
$router->get('/permission', ["Controllers\PermissionController", 'checkPermission']);

//Route Dashboard 
$router->get('/dashboard/parametre', ["Controllers\ParametreController", 'index'])->auth();

$router->get('/dashboard/temoignage', ["Controllers\TemoignageController", 'index'])->auth();
$router->put('/dashboard/temoignage', ["Controllers\TemoignageController", 'update'])->auth();
$router->delete('/dashboard/temoignage', ["Controllers\TemoignageController", 'delete'])->auth();

$router->get('/dashboard/employe', ["Controllers\EmployeController", 'index'])->auth();

$router->get('/dashboard/message', ["Controllers\MessageController", 'index'])->auth();
$router->put('/dashboard/message', ["Controllers\MessageController", 'update'])->auth();

//Route API
$router->get('/filtre', ["Controllers\FilterAPIController", "getAll"]);
$router->get('/filtre/params', ["Controllers\FilterAPIController", "filter"]);

//Route _csrf
$router->get('/getcsrf', ["Controllers\_csrfController", 'index'])->auth();

//Call route
return $router->dispatch();
