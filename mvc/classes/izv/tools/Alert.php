<?php

namespace izv\tools;

class Alert {
    
    static private $defaultMessages  = array(
        'insert' => array('No se ha podido insertar.', 'Se ha insertado correctamente.'),
        'delete' => array('No se ha podido borrar.', 'Se ha borrado correctamente.'),
        'edit' => array('No se ha podido modificar.', 'Se ha modificado correctamente.'),
        'activate' => array('No se ha podido activar.', 'Se ha activado correctamente.'),
        'login' => array('No se ha podido logear.', 'Se ha logeado correctamente.'),
        'register' => array('No se ha podido registrar.', "Se ha registrado correctamente.
            <br> Ahora debe activarse en el correo que le hemos enviado"),
        'captcha' => array('No se aceptan robots xd', 'Correcto usted no es un robot :)'),
        'clave' => array('La contraseña no coincide.', 'Clave correctamente escrita'),
        'correo' => array('Correo erroneo.', 'Correo Correcto.'),
    );
    
    static private $tipos = array('alert-danger', 'alert-success');
    
    
    // Constantes
    const INSERT = 'insert',
            DELETE = 'delete',
            EDIT = 'edit',
            ACTIVATE = 'activate',
            LOGIN = 'login',
            REGISTER = 'register';
            
    
    // Variables de Instancia
    private $type,
            $result;
    
    function __construct($type, $resutl) {
        $this->type = $type;
        $this->result = $resutl;
    }

    function getAlert() {
        $pos = $this->result;
        if($pos <= 0) {
            $pos = 0;
        }
        $string = '';
        if(isset(self::$defaultMessages[$this->type])) {
            $clase = self::$tipos[$pos];
            $mensaje = self::$defaultMessages[$this->type][$pos];
            $string = '<div class="alert ' . $clase . '" role="alert">' . $mensaje . '</div>';
        }
        return $string;
    }

    static function getMessage($op, $result){
        $a = new Alert($op, $result);
        return $a->getAlert();
    }
    
/*
 -- BootsTrap -- Alert --
<div class="alert alert-primary" role="alert">Text</div>
<div class="alert alert-secondary" role="alert">Text</div>
<div class="alert alert-success" role="alert">Text</div>
<div class="alert alert-danger" role="alert">Text</div>
<div class="alert alert-warning" role="alert">Text</div>
<div class="alert alert-info" role="alert">Text</div>
<div class="alert alert-light" role="alert">Text</div>
<div class="alert alert-dark" role="alert">Text</div>
*/
}