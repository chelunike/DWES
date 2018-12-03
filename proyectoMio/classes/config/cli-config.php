<?php

require_once 'doctrine.php';
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);