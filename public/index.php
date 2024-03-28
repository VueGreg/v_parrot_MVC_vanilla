<?php

require '../vendor/autoload.php';

use Router\Router;

$router = new Router();

$router->get('/', ["Controllers\HomeController", "index"]);

$router->get('/about', ["Controllers\AboutController", 'index']);
