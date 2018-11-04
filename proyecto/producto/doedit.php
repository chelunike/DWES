<?php

require '../classes/autoload.php';

use izv\database\Database;
use izv\data\Producto;
use izv\manager\ManageProducto;
use izv\tools\Reader;
use izv\tools\Tools;
use izv\tools\Alert;


// 1º Comprobar si puede hacerlo
// 2º Validar producto (datos de entrada)
// 3º Ya podemos hacerlo

$producto = Reader::readObject('izv\data\Producto');

$resultado = 0;
if($producto !== null) {
    $db = new Database();
    
    $manager = new ManageProducto($db);
    
    if($manager->edit($producto)){
        $resultado = 1;
    }
}

// Estaria bien devolver que operacion se ha realizado
$url = 'index.php?op=' . Alert::EDIT . '&resultado=' . $resultado;
//echo $url;
header('Location: ' . $url);

