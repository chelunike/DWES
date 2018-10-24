<?php
require '../clases/Autoload.php';
// Ruta del archivo -- OJO!!
$path = App::PATH;

// Resultado por defecto
$resultado = -1;

// Recojemos los datos
$nombre = Reader::read('nombre');
$fichero = new Upload('fichero');

if($nombre !== null && $fichero->getError() === 0) {
    $fichero->setPolicy(Upload::POLICY_KEEP);
    $fichero->setType('image');
    $fichero->setTarget($path);
    //Cojemos la extension del nombre original
    $extension = '.' . pathinfo($fichero->getName())['extension'];
    
    $fichero->setName($nombre . $extension);
    if($fichero->upload()) {
        $resultado = 0;
    }else{
        $resultado = $fichero->getError();
        if($resultado === 3){
            $resultado = 1;
        }
    }
    
}

// Estaria bien devolver que operacion se ha realizado
$url = 'index.php?result=' . $resultado;
header('Location: ' . $url);
