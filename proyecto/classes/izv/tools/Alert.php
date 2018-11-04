<?php

namespace izv\tools;

class Alert {
    
    //DESING
    static private $HEADER = '<div class="alert alert-XXX" role="alert">YYY</div>',
            $WARNING = 2,
            $INFO = 3,
            $LIGHT = 4,
            $DARK = 5,
            $SUCCESS = 6;
    
    static private $mensajes = array(
        'insertproducto' => array('No se ha podido insertar.', 'Se ha insertado correctamente.'),
        'deleteproducto' => array('No se ha podido borrar.', 'Se ha borrado correctamente.'),
        'editproducto' => array('No se ha podido modificar.', 'Se ha modificado correctamente.')
    );
    
    static private $clases = array('alert-danger', 'alert-success');
    
    
    // Constantes
    const TYPE_ERROR = 0,
            TYPE_WARNING = 1,
            TYPE_INFO = 2,
            TYPE_LIGHT = 3,
            TYPE_DARK = 4,
            TYPE_SUCCESS = 5,
            INSERT = 'insertproducto',
            DELETE = 'deleteproducto',
            EDIT = 'editproducto';
            
    
    // Variables de Instancia
    private $op,
            $result;
    
    function __construct($op, $resutl) {
        $this->op = $op;
        $this->result = $resutl;
    }

    function getAlert() {
        $pos = 1;
        if($this->result<=0) {
            $pos = 0;
        }
        $string = '';
        if(isset(self::$mensajes[$this->op])) {
            $clase = self::$clases[$pos];
            $mensaje = self::$mensajes[$this->op][$pos];
            $string = '<div class="alert ' . $clase . '" role="alert">' . $mensaje . '</div>';
        }
        return $string;
    }

    static function getMessage($op, $result){
        $a = new Alert($op, $result);
        return $a->getAlert();
    }
    
    //primary secondary success  danger warning  info light dark
    // str_replace (  $search ,  $replace , $subject )
    static function getMessageM() {
        
    }

}