<?php

require 'classes/autoload.php';
require 'classes/vendor/autoload.php';

use izv\data\Usuario;
use izv\tools\Reader;
use izv\tools\Alert;
use izv\app\App;
use izv\tools\Session;

// Cargamos las plantillas
$loader = new \Twig_Loader_Filesystem(__DIR__.'/templates');
// Cargamos el Cargador
$twig = new \Twig_Environment($loader);

$sesion = new Session(App::SESSION_NAME);

$usuario = new Usuario();
$usuario->setNombre('Mario')
        ->setActivo(1);

$resultado = Reader::read('resultado');
$op = Reader::read('op');
$alert = Alert::getMessage($op, $resultado);

// PlaceHolder solo texto
$data = array('title' => 'Patata',
                'logged' => $sesion->isLogged(),
                'usuario' => $usuario,
                'alert' => $alert);

// Renderizado
echo $twig->render('home.twig', $data);