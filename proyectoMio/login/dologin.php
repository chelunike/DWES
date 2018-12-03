<?php

use izv\database\Database;
use izv\data\Usuario;
use izv\manager\ManageUsuario;
use izv\tools\Reader;
use izv\tools\Alert;
use izv\app\App;
use izv\tools\Tools;
use izv\tools\Session;

require '../classes/autoload.php';

$user = Reader::read('correo');
$clave = Reader::read('clave');

// Sin Doctrine
//$db = new Database();
//$manager = new ManageUsuario($db);
//$login = $manager->login($user ,$clave);

// - Login con doctrine
require '../classes/config/doctrine.php';

function login2($correo, $clave, $entityManager) {
    $resultado = false;
    $sql = 'select u from izv\data\Usuario u where u.correo = :correo and u.activo = 1';
    $sentencia = $entityManager->createQuery($sql);
    $sentencia->setParameter('correo', $correo);
    $r = $sentencia->getResult();
    if(count($r) > 0) {
        $usuario = $r[0];
        if(Tools::verificarClave($clave, $usuario->getClave())){
            $usuario->setClave('');
            $resultado = $usuario;
        }
    }
    return $resultado;
}

$login = login2($user, $clave, $entityManager);

$resultado = 0;
echo Tools::view($login);
$page = '../index.php';
if($login) {
    $sesion = new Session(App::SESSION_NAME);
    $sesion->login($login);
    $page = '../usuario/index.php';
    $resultado = 1;
}

// Estaria bien devolver que operacion se ha realizado
$url = $page . '?op=' . Alert::LOGIN . '&resultado=' . $resultado;
echo $url; 
header('Location: ' . $url);