<?php
namespace izv\view;

use izv\model\Model;
use izv\tools\Tools;

/**
 * El controlador
 * 
 * 
 */
class View {

    private $model;

    function __construct(\izv\model\Model $model) {
        $this->model = $model;
    }
    
    function render($accion) {
        $data = $this->model->getViewData();
        return Tools::print('Estas haciendo: ' . $accion) . Tools::view($data);
    }
    
    function getModel() {
        return $this->model;
    }
    
    function __destruct() {
        
    }
}