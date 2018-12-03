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
if(!$sesion->isLogged()) {
    header('Location: ../index.php');
    exit();
}
$usuario = $sesion->getLogin();

$resultado = Reader::read('resultado');
$op = Reader::read('op');
$alert = Alert::getMessage($op, $resultado);

// --  Cargar el usuario por id
$id = Reader::read('id');
$user = null;
if($id !== null && $usuario->getAdministrador()) {
    //$db = new Database();
    //$manager = new ManageUsuario($db);
    //$user = $manager->get($id);
    
    // Por doctrine
    require '../classes/config/doctrine.php';
    $user = $entityManager->getRepository('izv\data\Usuario')
                    ->findOneBy(array('id' => $id));
    
} else {
    $user = $usuario;
}

// Cargamos el usuario a editar
$data = array('title' => 'Patata',
                'logged' => $sesion->isLogged(),
                'usuario' => $user,
                'alert' => $alert);

// Renderizado
if($usuario->getAdministrador()) {
    echo $twig->render('editRoot.twig', $data);
} else {
    echo $twig->render('editSelf.twig', $data);
}