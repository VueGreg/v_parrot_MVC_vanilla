<?php

namespace Utils;

use Middleware\Auth;
use Middleware\CrossSiteRequestForgery;

class Controller
{
    public function view(string $filename, array $datas = [], bool $hasRouter = false)
    {
        $path = "../resources/views/index.php";
        $csrf = null;
        $auth = new Auth();

        if ($auth->verify($filename) && !$auth->getPageVitrine()) {
            $csrf = new CrossSiteRequestForgery();
            $csrf->generateCSRFToken();
        }

        $vue_info = array(
            'filename' => $filename,
            'datas' => $datas,
            'hasRouter' => $hasRouter,
            'csrf_token' => ($csrf !== null) ? $csrf->getCSRFToken() : null
        );
        
        if (file_exists($path)) {
            ob_start();
            extract($vue_info);
            require_once $path;

            //return ob_get_clean();
        }else var_dump($path . " n'existe pas");
    }

    public function renderApi(array $datas): void
    {
        header('Content-Type: application/json');
        echo json_encode($datas);

        exit;
    }
}