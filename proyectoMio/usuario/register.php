<?php

require '../classes/autoload.php';
require '../classes/vendor/autoload.php';

use izv\data\Usuario;
use izv\tools\Reader;
use izv\app\App;
use izv\tools\Alert;
use izv\tools\Session;
use izv\tools\Tools;
use izv\tools\Mail;
use izv\database\Database;
use izv\manager\ManageUsuario;

// - Read user object
$user = Reader::readObject('izv\data\Usuario');
$clave2 = Reader::read('clave2');
/*
//Insert sin Doctrine
$db = new Database();
$manager = new ManageUsuario($db);
*/

echo Tools::view($user);
if($user->getClave() === $clave2) {
    $user->setClave(Tools::encriptar($user->getClave()));
    $user->setActivo(false);
    $user->setAdministrador(false);
    
    /* Sin doctrine
    echo Tools::view($user);
    $user->setClave(Tools::encriptar($user->getClave()));
    
    if($manager->add($user)) {
        $resultado = 1;
    }
    */
    
    // Insert con Doctrine
    require '../classes/config/doctrine.php';
    $entityManager->persist($user);
    $entityManager->flush();
}
$resultado = 0;
if($user->getId() !== null) {
    $resultado = 1;
    Mail::sendActivation($user, 'https://daw-p07470.c9users.io/server/proyectoMio/login/activate.php');
}

echo Tools::view($user);

// Estaria bien devolver que operacion se ha realizado
$url = '../index.php?op=' . Alert::REGISTER . '&resultado=' . $resultado;
echo $url; 
header('Location: ' . $url);