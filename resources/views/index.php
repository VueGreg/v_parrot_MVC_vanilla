<?php 
    require_once(__DIR__ . './helpers.php'); 
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Vite App</title>
        <?= vite('main.js') ?>
        
    </head>

    <body>
        <div id="app">
            <div id="vue-app" data-php-data='<?php echo htmlspecialchars(json_encode($vue_info['datas'], JSON_UNESCAPED_SLASHES)); ?>'></div>
        </div>
        <?php 
            $filename = $vue_info['filename'];
            echo "<script>var filename = '{$filename}';</script>";
            $hasRouter = $vue_info['hasRouter'];
            echo "<script>var hasRouter = '{$hasRouter}';</script>";
        ?>
        <script src="https://kit.fontawesome.com/a0d5f723cd.js" crossorigin="anonymous"></script>
    </body>

</html>
