<?php
namespace izvdwes\data;

class Punto {
    use Comun;
    
    // Atributos / Variables de Instancia
    private $x ,$y;
    
    // Constructor
    function __construct($x=0, $y = 0){
        $this-> x = $x;
        $this-> y = $y;
    }
    
    // Metodos
    /*
    function introspeccion(){
        foreach($this as $atributo => $valor){
            echo $atributo .': '. $valor . '<br>';
        }
        
    }*/
    
    function __toString(){
        return '(' . $this->x . ', ' . $this->y .')'; 
    }
    
    // Get Y Set
    function getX() {
        return $this->x;
    }

    function getY() {
        return $this->y;
    }

    function setX($x) {
        $this->x = $x;
        return $this;
    }

    function setY($y) {
        $this->y = $y;
        return $this;
    }

    
}