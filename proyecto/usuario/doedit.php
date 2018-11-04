<?php

require '../classes/autoload.php';

use izv\database\Database;
use izv\data\Usuario;
use izv\manager\ManageUsuario;
use izv\tools\Reader;
use izv\tools\Tools;
use izv\tools\Alert;


// 1º Comprobar si puede hacerlo
// 2º Validar Usuario (datos de entrada)
// 3º Ya podemos hacerlo

$usuario = Reader::readObject('izv\data\Usuario');

echo Tools::view($usuario);

$resultado = 0;
if($usuario !== null) {
    $db = new Database();
    
    $manager = new ManageUsuario($db);
    
    if($manager->edit($usuario) > 0){
        $resultado = 1;
    }
}

// Estaria bien devolver que operacion se ha realizado
$url = 'index.php?op=' . Alert::EDIT . '&resultado=' . $resultado;
echo $url;
header('Location: ' . $url);

