<?php
require 'classes/autoload.php';
require 'classes/vendor/autoload.php';

use izv\mvc\FrontController;
use izv\tools\Tools;
use izv\tools\Reader;


// -- Recogida de parametros -- !! A automatizar en tools
$params = '-';
if(isset($_GET['params'])) {
    $params = $_GET['params'];
}

//echo '<h1>Valor que se ha obtenido:' . $params . '</h1>';
//echo '<h1>' . $params . '</h1>';

$parametros = Reader::read('params');
$ruta = '';
$accion = '';
if($parametros !== null) {
    $parts = explode('/', $parametros);
    if(isset($parts[0])) {
        $ruta = $parts[0];        
    }
    if(isset($parts[1])) {
        $accion = $parts[1];
    }
}

// Es un echo que estos echos son necesarios
echo Tools::view(explode('/', $params));
echo Tools::print('Ruta: ' . $ruta);
echo Tools::print('Accion: ' . $accion);

// -- La Magia del Controlador Frontal --
$frontController = new FrontController($ruta, $accion);
$frontController->doAction();

// -- Respuesta del Controlador Frontal --
//echo $frontController->render();