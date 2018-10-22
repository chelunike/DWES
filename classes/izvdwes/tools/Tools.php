<?php

namespace izvdwes\tools;

class Tools {

    static function view($any) {
        echo self::varDump($any);
    }
    
    static function varDump($any) {
        return '<pre>' . var_export($any, true) . '</pre>';
    }
    
    // Nombre mejor printHTML, but I <3 Python :)
    static function print($cad, $tag='p') {
        echo '<'. $tag .'>'. $cad . '</'. $tag .'>';
    }
}