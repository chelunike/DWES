<?php

 //Importancia del orden de los atributos

namespace izvdwes\data;

/**
 * Alumno
 *
 * @author yo
 */
class Alumno {
    
    //Usar trait
    //use Comun;
    use \izvdwes\common\Comun;
    
    //Atributos 
        private $apellidos,
            $dni,
            $fechaNacimiento,
            $nombre,
            $numeroMatricula,
            $sexo,
            $telefono;

    
    //Constructor
    function __construct($dni = null, $nombre = null, $apellidos = null, $numeroMatricula = null, $fechaNacimiento =  null,
                            $sexo = null, $telefono = null) {
        $this->apellidos = $apellidos;
        $this->dni = $dni;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->nombre = $nombre;
        $this->numeroMatricula = $numeroMatricula;
        $this->sexo = $sexo;
        $this->telefono = $telefono;
    }
    
    //To String
    
    /*function introspeccion(){
        foreach($this as $atributo => $valor){
            echo $atributo .': '. $valor . '<br>';
        }
        
    }*/
    
    function __toString(){
        return 'Alumno: ' . $this->nombre;
    }
    
    //Get y Set
    function getApellidos() {
        return $this->apellidos;
    }

    function getDni() {
        return $this->dni;
    }

    function getFechaNacimiento() {
        return $this->fechaNacimiento;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getNumeroMatricula() {
        return $this->numeroMatricula;
    }

    function getSexo() {
        return $this->sexo;
    }

    function getTelefono() {
        return $this->telefono;
    }
    
    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
        return $this;
    }

    function setDni($dni) {
        $this->dni = $dni;
        return $this;
    }

    function setFechaNacimiento($fechaNacimiento) {
        $this->fechaNacimiento = $fechaNacimiento;
        return $this;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
        return $this;
    }

    function setNumeroMatricula($numeroMatricula) {
        $this->numeroMatricula = $numeroMatricula;
        return $this;
    }

    function setSexo($sexo) {
        $this->sexo = $sexo;
        return $this;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
        return $this;
    }

    
}