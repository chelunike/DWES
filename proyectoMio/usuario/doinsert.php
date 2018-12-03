<?php

require '../classes/autoload.php';
require '../classes/vendor/autoload.php';

use izv\data\Usuario;
use izv\tools\Reader;
use izv\tools\Alert;
use izv\app\App;
use izv\tools\Session;
use izv\tools\Tools;
use izv\tools\Mail;
use izv\database\Database;
use izv\manager\ManageUsuario;

// - Read user object
$user = Reader::readObject('izv\data\Usuario');

// - Sesion
$sesion = new Session(App::SESSION_NAME);
$usuario = $sesion->getLogin();
if(!$sesion->isLogged() || $user == null || !$usuario->getAdministrador()) {
    header('Location: ../index.php');
    exit();
}
/*
//Insert sin Doctrine
$db = new Database();
$manager = new ManageUsuario($db);

echo Tools::view($user);
$user->setClave(Tools::encriptar($user->getClave()));

if($manager->add($user)) {
    $resultado = 1;
}
*/
// Insert con Doctrine

$user->setClave(Tools::encriptar($user->getClave()));

require '../classes/config/doctrine.php';
$entityManager->persist($user);
$entityManager->flush();

$resultado = 0;
if($user->getId() != null) {
    $resultado = 1;
} 

echo Tools::view($user);

// Estaria bien devolver que operacion se ha realizado
$url = 'index.php?op=' . Alert::INSERT . '&resultado=' . $resultado;
echo $url; 
header('Location: ' . $url);