<?php

namespace Controllers;

use Countable;

class Controller
{
    public function view(string $filename, array $datas = [])
    {
        $path = "../resources/views/index.php";

        $vue_info = array(
            'filename' => $filename,
            'datas' => $datas
        );
        
        if (file_exists($path)) {

            ob_start();
            extract($vue_info);
            require_once $path;

            //return ob_get_clean();
        }else var_dump($path . " n'existe pas");
    }

    public function renderApi(array $datas): mixed
    {
        return json_encode($datas);
    }

    public function countData(array $datas): int
    {
        return count($datas);
    }
}