<?php
namespace izv\view;

use izv\model\Model;
use izv\tools\Reader;
use izv\tools\Alert;
use izv\tools\Tools;

/**
 * El view
 * 
 */
class UserView extends View {

    function __construct(\izv\model\Model $model) {
        parent::__construct($model);
    }
    
    function render($accion) {
        $this->getModel()->set('template_route', 'templates/user/');
        $data = $this->getModel()->getViewData();
        
        require_once 'classes/vendor/autoload.php';
        
        // Recojer datos (posible alert)
        $type = Reader::read('a');
        $r = Reader::read('r');
        
        if(isset($type)) {
            if(!isset($r)) {
                $r = 0;
            }
            $alert = Alert::getMessage($type, $r);
            $data['alert'] = $alert;
        }
        
        // Cargar Plantillas
        $loader = new \Twig_Loader_Filesystem('templates/user');
        $twig = new \Twig_Environment($loader);
        
        return $twig->render($this->getModel()->get('template_file'), $data);
        //return Tools::print('Estas haciendo: ' . $accion) . Tools::view($data);
    }
    
}