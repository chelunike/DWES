<?php

namespace izv\tools;

class Alert {
    
    static private $mensajes = array(
        'insert' => array('No se ha podido insertar.', 'Se ha insertado correctamente.'),
        'delete' => array('No se ha podido borrar.', 'Se ha borrado correctamente.'),
        'edit' => array('No se ha podido modificar.', 'Se ha modificado correctamente.'),
        'activate' => array('No se ha podido activar.', 'Se ha activado correctamente.'),
        'login' => array('No se ha podido logear.', 'Se ha logeado correctamente.'),
        'register' => array('No se ha podido registrar.', 'Se ha registrado correctamente.')
    );
    
    static private $clases = array('alert-danger', 'alert-success');
    
    
    // Constantes
    const INSERT = 'insert',
            DELETE = 'delete',
            EDIT = 'edit',
            ACTIVATE = 'activate',
            LOGIN = 'login',
            REGISTER = 'register';
            
    
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
    

}