<?php
namespace izv\view;

use izv\model\Model;
use izv\tools\Tools;

/**
 * El view
 * 
 */
class FirstView extends View {

    function __construct(\izv\model\Model $model) {
        parent::__construct($model);
    }
    
    function render($accion) {
        $this->getModel()->set('template_route', 'templates/bootstrap/');
        $data = $this->getModel()->getViewData();
        
        require_once 'classes/vendor/autoload.php';
        
        $loader = new \Twig_Loader_Filesystem('templates/bootstrap');
        $twig = new \Twig_Environment($loader);
        
        return $twig->render($this->getModel()->get('template') . '.twig', $data);
        //return Tools::print('Estas haciendo: ' . $accion) . Tools::view($data);
    }
    
}