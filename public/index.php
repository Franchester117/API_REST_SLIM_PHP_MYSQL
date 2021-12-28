<?php
 
    require '../vendor/autoload.php';
    require '../src/config/conexion.php';
    require '../src/routes/cliente.php';

    $app = new \Slim\App;
    
    //Rutas cliente
    require '../src/routes/cliente.php';

    $app->run();
?>