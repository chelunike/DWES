<?php

namespace izv\tools;

class Tools {

    static function view($any) {
        echo self::varDump($any);
    }
    
    static function varDump($any) {
        return '<pre>' . var_export($any, true) . '</pre>';
    }
    
    // Nombre mejor printHTML, but I <3 Python :)
    static function print($cad, $tag='p') {
        return '<'. $tag .'>'. $cad . '</'. $tag .'>';
    }
    
    static function url() {
        $url = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $parts = pathinfo($url);
        return $parts['dirname'] . '/';
    }
    
}