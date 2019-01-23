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
    
    function action() {
        $this->model->set('Patata', ':)');
        $this->model->set('Info', ' Cuentame mas :)');
    }
    
    /*function patata() {
        $this->model->set('Patata', ':)');
        $this->model->set('Info', ' Top secret :)');
        $this->model->set('Secret', 'Cowsay for the best :)');
    }*/
    
    function getSession() {
        return $this->sesion;
    }
    
    function getModel() {
        return $this->model;
    }
    
    function __destruct() {
        
    }
}