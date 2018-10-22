<?php
namespace izvdwes\data;

/**
 * Alumno
 *
 * @author yo
 */
class AlumnoReadable implements Readable {
    
    //Atributos 
    private $id, $nombre, $apellidos, $fechaNaci, $sexo, $dni;
    
    //Constructor
    function __construct($dni = null, $nom = null, $apellidos = null){
        $this->nombre = $nom;
    }
    
    //To String
    
    /*function introspeccion(){
        foreach($this as $atributo => $valor){
            echo $atributo .': '. $valor . '<br>';
        }
        
    }*/
    
    
    function readableGet(){
        $array = array();
        foreach($this as $atributo => $valor){
            $array[$atributo] = $valor;
        }
        return $array;
    }

    function readableSet(array $array){
        foreach($this as $atributo => $valor){
            $methodSet = 'set'.$atributo;
            if(isset($array[$atributo])){
                $this->$atributo = $array[$atributo];
            }
        }
        return $this;
    }
    
    function __toString(){
        $cad = get_class().': ';
        foreach($this as $atributo => $valor){
            $cad .= $atributo .' = '. $valor . '<br>';
        }
        return $cad;
    }
    
    //Get y Set
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getFechaNaci() {
        return $this->fechaNaci;
    }

    function getSexo() {
        return $this->sexo;
    }

    function getDni() {
        return $this->dni;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    function setFechaNaci($fechaNaci) {
        $this->fechaNaci = $fechaNaci;
    }

    function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    function setDni($dni) {
        $this->dni = $dni;
    }


    
}

/*<?php

class Alumno {

    private $apellidos,
            $dni,
            $fechaNacimiento,
            $nombre,
            $numeroMatricula,
            $sexo,
            $telefono;

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

    function __toString() {
        return 'El alumno es: ' . $this->nombre;
    }

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

    function introspeccion() {
        foreach($this as $atributo => $valor) {
            echo $atributo . ': ' . $valor . '<br>';
        }
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
*/
