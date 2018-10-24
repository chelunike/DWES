<?php

class Autoload {
    static function load($clase) {
        $ruta = dirname(__FILE__) . '/' . $clase . '.php';
        if (file_exists($ruta)) {
            require($ruta);
        }
    }
}
spl_autoload_register('Autoload::load');