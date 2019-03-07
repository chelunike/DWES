<?php
namespace izv\controller;

use izv\app\App;
use izv\model\Model;
use izv\tools\Session;

/**
 * El controlador
 * 
 * 
 */
class Controller {

    private $model, $sesion;

    function __construct(\izv\model\Model $model) {
        $this->model = $model;
        $this->sesion = new Session(App::SESSION_NAME);
        $this->getModel()->set('base_url', App::BASE);
    }
    
    function action($params) {
        
    }
    
    function getSession() {
        return $this->sesion;
    }
    
    function getModel() {
        return $this->model;
    }
    
    function location($route, $alert=null, $ecode=null) {
        $a = '';
        if(isset($alert)) {
            $r = '';
            if(isset($ecode))
                $r = '&r=' . $ecode;
            $a = '?a=' . $alert . $r;
        }
        header('Location: '.App::BASE . $route . $a);
        exit();
    }
}