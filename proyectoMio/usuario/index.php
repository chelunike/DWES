<?php

require '../classes/autoload.php';
require '../classes/vendor/autoload.php';

use izv\data\Usuario;
use izv\tools\Reader;
use izv\tools\Alert;
use izv\app\App;
use izv\tools\Session;
use izv\database\Database;
use izv\manager\ManageUsuario;

// Cargamos las plantillas
$loader = new \Twig_Loader_Filesystem('../templates');
// Cargamos el Cargador
$twig = new \Twig_Environment($loader);

// - Sesion
$sesion = new Session(App::SESSION_NAME);
if(!$sesion->isLogged()) {
    header('Location: ../index.php');
    exit();
}
$usuario = $sesion->getLogin();

// - Alert
$resultado = Reader::read('resultado');
$op = Reader::read('op');
$alert = Alert::getMessage($op, $resultado);

// Sacamos la lista de usuarios
$db = new Database();
$manager = new ManageUsuario($db);

$listaUsuarios = $manager->getAll();

// Con doctrine
require '../classes/config/doctrine.php';

$repositorioObj = $entityManager->getRepository('izv\data\Usuario');
$listaUsuarios2 = $repositorioObj->findAll();


// Cargamos los datos
$data = array('title' => 'Patata',
                'logged' => $sesion->isLogged(),
                'usuarios' => $listaUsuarios2,
                'alert' => $alert);

// Renderizado
if($usuario->getAdministrador()) {
    echo $twig->render('tablaRoot.twig', $data);
} else {
    echo $twig->render('tablaBasic.twig', $data);
}