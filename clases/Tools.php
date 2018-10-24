<?php

/**
 * Herramientas Varias
 *
 * @author yo
 */
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
    
    static function getListFiles($path, $type='') {
        $files = array();
        if(isset($path) && trim($path) !== '') {
            foreach(scandir($path) as $file) {
                $ruta = $path . $file;
                if(self::isValidType($ruta, $type)) {
                    $files[] = $file; 
                }
            }
        }
        return $files;
    }
    
    static function isValidType($path, $type) {
        $result = true;
        if(isset($path) && trim($type) !== '') {
            $tipo = shell_exec('file --mime ' . $path);
            $pos = strpos($tipo, $type);
            if($pos === false){
                $result = false;
            }
        }
        return $result;
    }

}