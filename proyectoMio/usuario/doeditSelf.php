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


// - Sesion
$sesion = new Session(App::SESSION_NAME);
if(!$sesion->isLogged()) {
    header('Location: ../index.php');
    exit();
}
$usuario = $sesion->getLogin();

// --  Cargar el usuario por id
$resultado = 0;
$id = Reader::read( 'id');
if($id !== null) {
    // Por doctrine
    require '../classes/config/doctrine.php';
    $user = $entityManager->getRepository('izv\data\Usuario')
                        ->findOneBy(array('id' => $id));
    echo Tools::view($user);
    if($user !== null) {
        $nombre = Reader::read('nombre');
        $correo = Reader::read('correro');
        $clave = Reader::read('clave');
        $delete = Reader::read('bajaTmp');
        if($nombre !== null) {
            $user->setAlias(Reader::read('alias'));
            $user->setNombre($nombre);
            $resultado = 1;
        } else if($correo !== null) {
            $user->setCorreo($correo);
            $user->setActivo(false);
            Mail::sendActivation($user, 'https://daw-p07470.c9users.io/server/proyectoMio/login/activate.php');
            $resultado = 1;
        } else if($clave !== null) {
            $clave2 = Reader::read('claveNueva');
            if(Tools::verificarClave($clave, $user->getClave())) {
                $clave2 = Tools::encriptar($clave2);
                $user->setClave($clave2);
                $resultado = 1;
            } else {
                $resultado = 0;
            }
        } else if($delete !== null) {
            if($delete) {
                $user->setActivo(false);
            } else {
                $entityManager->remove($user);
            }
            $entityManager->flush();
            $sesion->logout();
            header('Location: ../index.php');
            exit();
        }
        
        echo Tools::view($user);
        
        $entityManager->flush();
        $resultado = 1;
    }
}
// Estaria bien devolver que operacion se ha realizado
$url = 'index.php?op=' . Alert::EDIT . '&resultado=' . $resultado;
echo $url; 
header('Location: ' . $url);