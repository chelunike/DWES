<?php

require '/home/ubuntu/workspace/server/proyectoMio/classes/vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array("/home/ubuntu/workspace/server/proyectoMio/classes/config/src");
$isDevMode = false;

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'usuariobd',
    'password' => 'clavebd',
    'dbname'   => 'project'
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

