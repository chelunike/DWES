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

// - Sesion
$sesion = new Session(App::SESSION_NAME);
if(!$sesion->isLogged()) {
    header('Location: ../index.php');
    exit();
}
$usuario = $sesion->getLogin();

// --  Cargar el usuario por id
$resultado = 0;
$id = Reader::read('id');
if($id !== null && $usuario->getAdministrador()) {
    // Por doctrine
    require '../classes/config/doctrine.php';
    $user = $entityManager->getRepository('izv\data\Usuario')
                        ->findOneBy(array('id' => $id));
    echo Tools::view($user);
    if($user !== null) {
        $user->setCorreo(Reader::read('correo'));
        $user->setAlias(Reader::read('alias'));
        $user->setNombre(Reader::read('nombre'));
        $user->setActivo(Reader::read('activo'));
        $user->setAdministrador(Reader::read('administrador'));
        $clave = Reader::read('clave');
        if($clave !== null) {
            $clave = Tools::encriptar($clave);
            $user->setClave($clave);
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