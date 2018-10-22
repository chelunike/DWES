<?php
namespace izvdwes\data;

/**
 * Clase producto de c4 por que tiene destructor
 */
class Producto{
    
    private static $contador=0;
    
    private $id, $nombre, $cantidad, $precio;
    
    function __construct($id=null, $nombre="", $cantidad=0, $precio=0){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->cantidad = $cantidad;
        $this->precio = $precio;
        $contador++;
    }
    
    function __destruct(){
        self::$contador--;
    }
    
    static function getContador(){
        return self::$contador . '<br>';
    }
    
}