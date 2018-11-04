<?php
namespace izv\data;

/**
 * Clase producto de c4 por que tiene destructor
 */
class Producto{
    
    use \izv\common\Comun;

    private $id, $nombre, $precio, $observaciones;
    
    function __construct($id=null, $nombre="", $precio=0, $observaciones=''){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->observaciones = $observaciones;
    }
    
    
    // Get y Set
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }
}