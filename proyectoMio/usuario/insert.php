<?php

require '../classes/autoload.php';
require '../classes/vendor/autoload.php';

use izv\data\Usuario;
use izv\tools\Reader;
use izv\tools\Alert;
use izv\app\App;
use izv\tools\Session;
use izv\tools\Tools;
use izv\database\Database;
use izv\manager\ManageUsuario;

// Cargamos las plantillas
$loader = new \Twig_Loader_Filesystem('../templates');
// Cargamos el Cargador
$twig = new \Twig_Environment($loader);

// - Sesion
$sesion = new Session(App::SESSION_NAME);
$usuario = $sesion->getLogin();

// Datos para la plantilla
$data = array('title' => 'Patata');

// Renderizado
if(!$sesion->isLogged()) {
    echo $twig->render('register.twig', $data);
} else if($sesion->isLogged() && $usuario->getAdministrador()) {
    echo $twig->render('insertRoot.twig', $data);
} else {
    header('Location: ../index.php');
    exit();
}