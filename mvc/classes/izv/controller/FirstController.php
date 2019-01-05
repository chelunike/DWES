<?php
namespace izv\controller;

use izv\app\App;
use izv\model\Model;
use izv\tools\Session;

/**
 * El controlador
 * 
 */
class FirstController extends Controller {

    /**
     * Opcional si se quiere añadir algo
     * 
     */
    function __construct(\izv\model\Model $model) {
        parent::__construct($model);
    }
    
    
    // -- Acciones -- 
    function action() {
        $this->getModel()->set('template', '_base');
        $this->getModel()->set('title', 'First Controller');
    }
    
    function patata() {
        $this->getModel()->set('template', '_base');
        $this->getModel()->set('title', 'Patata :)');
        $this->getModel()->set('subtitle', ' Top secret :)');
        $this->getModel()->set('info', 'Cowsay for the best :)');
    }
    
    
}