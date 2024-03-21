<?php

namespace Controllers;

class Controller
{
    public function view(string $path, array $datas = [])
    {
        $filename = "../src/Views/" . $path . ".php";
        
        if (file_exists($filename)) {

            ob_start();
            extract($datas);
            require $filename;

            //return ob_get_clean();
        }else var_dump($filename . " n'existe pas");
    }

    public function renderApi(array $datas)
    {
        return json_encode($datas);
    }
}