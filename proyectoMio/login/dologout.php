<?php

use izv\data\Usuario;
use izv\tools\Reader;
use izv\tools\Tools;
use izv\app\App;
use izv\tools\Session;

require '../classes/autoload.php';

$sesion = new Session(App::SESSION_NAME);
$sesion->logout();

// Estaria bien devolver que operacion se ha realizado
$url = '../index.php';
header('Location: ' . $url);