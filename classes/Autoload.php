<?php

spl_autoload_register(
    function ($clase) {
        $archivo = dirname(__FILE__) . '/'
            . str_replace('\\', '/', $clase)
            . '.php';
        //echo '</p>', $archivo .'</p>';
        if (file_exists($archivo)) {
            require $archivo;
        }
});
//https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md 