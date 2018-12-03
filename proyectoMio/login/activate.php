<?php

require '../classes/autoload.php';
require '../classes/vendor/autoload.php';

use izv\data\Usuario;
use izv\tools\Reader;
use izv\app\App;
use izv\tools\Alert;
use izv\tools\Tools;
use izv\database\Database;
use izv\manager\ManageUsuario;


// 1º Comprobar si puede hacerlo
// 2º Validar Usuario (datos de entrada)
// 3º Ya podemos hacerlo

$code = Reader::read('code');

$resultado = 0;
if($code !== null) {
    $usuario = null;
    // Obtain id
    $key = Tools::encryptJWT(App::CODE, App::JWT_CODE);
    
    //echo substr_compare($code, $key, 0);
    if(substr_compare($code, $key, 0)) {
        $id = Tools::decryptJWT(substr($code, strlen($key)), App::JWT_CODE);
        
        // Sin Doctrine
        //$db = new Database();
        //$manager = new ManageUsuario($db);
        //$usuario = $manager->get($id);

        // Con Doctrine
        require '../classes/config/doctrine.php';
        $usuario = $entityManager->getRepository('izv\data\Usuario')
                    ->findOneBy(array('id' => $id));
    }
    if($usuario !== null && !$usuario->getActivo()) {
        $usuario->setActivo(true);
        //if($manager->edit($usuario)) { // Sin doctrine
            $resultado  = 1;
        //}
        $entityManager->flush();
    }
}

// Estaria bien devolver que operacion se ha realizado
$url = '../index.php?op=' . Alert::ACTIVATE . '&resultado=' . $resultado;
echo $url;
header('Location: ' . $url);
