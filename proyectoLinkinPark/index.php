<?php
require 'classes/autoload.php';
require 'classes/vendor/autoload.php';

use izv\mvc\FrontController;
use izv\mvc\Router;
use izv\tools\Tools;
use izv\tools\Reader;

// -- Recogida de parametros -- !! A automatizar.
$parametros = Reader::read('params');

$params = Router::preProcessor($parametros);

//echo Tools::view($params);

// La magia del controlador frontal
// Todo en una funcion
FrontController::initController($params);