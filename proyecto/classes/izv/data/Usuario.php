<?php
namespace izv\data;

/**
 * Clase producto de c4 por que tiene destructor
 */
class Usuario{
    
    use \izv\common\Comun;

    private $id, 
            $correo, 
            $alias, 
            $nombre,
            $clave,
            $activo,
            $fechaalta;
    
    function __construct($id=null, $correo='', $alias='', $nombre="", $clave='', $activo=false, $fechaalta=null){
        $this->id = $id;
        $this->correo = $correo; 
        $this->alias = $alias;
        $this->nombre = $nombre;
        $this->clave = $clave;
        $this->activo = $activo;
        $this->fechaalta = $fechaalta;
    }
    
    
    // Get y Set
    
    function getId() {
        return $this->id;
    }

    function getCorreo() {
        return $this->correo;
    }

    function getAlias() {
        return $this->alias;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getClave() {
        return $this->clave;
    }

    function getActivo() {
        return $this->activo;
    }

    function getFechaalta() {
        return $this->fechaalta;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCorreo($correo) {
        $this->correo = $correo;
    }

    function setAlias($alias) {
        $this->alias = $alias;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    function setActivo($activo) {
        $this->activo = $activo;
    }

    function setFechaalta($fechaalta) {
        $this->fechaalta = $fechaalta;
    }


}