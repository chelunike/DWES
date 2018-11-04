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

$id = Reader::read('id');
$ids = Reader::readArray('ids');

$resultado = 0;
$db = new Database();
$manager = new ManageProducto($db);
if($id !== null && $manager->remove($id)) {
    $resultado = 1;
}else if($ids !== null){
    //$db->getConnection()->beginTransaction();
    $num = 0;
    foreach($ids as $id) {
        $num += $manager->remove($id);
    }
    
    if($num === count($ids)) { 
        //$db->getConnection()->commit();
        $resultado = 1;
    } else {
        //$db->getConnection()->rollBack();
    }
}

// Estaria bien devolver que operacion se ha realizado
$url = 'index.php?op=' . Alert::DELETE . '&resultado=' . $resultado;
header('Location: ' . $url);

