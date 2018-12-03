<?php

require '../classes/autoload.php';
require '../classes/config/doctrine.php';

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

$id = Reader::read('id');
$ids = Reader::readArray('ids');

$resultado = 0;
// Sin doctrine
//$db = new Database();
//$manager = new ManageUsuario($db);


if($id !== null) {
    $user = $entityManager->find('izv\data\Usuario', $id);
    $entityManager->remove($user);
    $entityManager->flush();
    $resultado = 1;
}else if($ids !== null){
    $num = 0;
    foreach($ids as $id) {
        $user = $entityManager->find('izv\data\Usuario', $id);
        if($user !== null) {
            $entityManager->remove($user);
        }
        $entityManager->flush();
    }
    $resultado = 1;
}

// Estaria bien devolver que operacion se ha realizado
$url = 'index.php?op=' . Alert::DELETE . '&resultado=' . $resultado;
echo $url;
header('Location: ' . $url);