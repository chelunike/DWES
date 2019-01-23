<?php
namespace izv\controller;

use izv\app\App;
use izv\model\Model;
use izv\tools\Session;

/**
 * El controlador
 * 
 */
class MainController extends Controller {

    /**
     * Opcional si se quiere añadir algo
     * 
     */
    function __construct(\izv\model\Model $model) {
        parent::__construct($model);
    }
    
    
    // -- Acciones -- 
    function action() {
        $this->getModel()->set('template_file', 'index.twig');
        $this->getModel()->set('template_css', 'styleHome.css');
        $this->getModel()->set('title', 'Main Controller');
        $this->getModel()->set('is_logged', $this->getSession()->isLogged());
    }
    
    function projects() {
        $this->getModel()->set('template_file', 'projects.twig');
        $this->getModel()->set('template_css', 'styleProjects.css');
        $this->getModel()->set('title', 'Main Controller');
        $this->getModel()->set('is_logged', $this->getSession()->isLogged());
    }
    
    function documentation() {
        $this->getModel()->set('template_file', 'documentation.twig');
        $this->getModel()->set('template_css', 'styleDocumentation.css');
        $this->getModel()->set('title', 'Main Controller');
        $this->getModel()->set('is_logged', $this->getSession()->isLogged());
    }
    
    function contact() {
        $this->getModel()->set('template_file', 'contact.twig');
        $this->getModel()->set('template_css', 'styleContact.css');
        $this->getModel()->set('title', 'Main Controller');
        $this->getModel()->set('is_logged', $this->getSession()->isLogged());
    }
    
    function patata() {
        $this->getModel()->set('template_file', 'index.html');
        $this->getModel()->set('title', 'Patata :)');
        $this->getModel()->set('subtitle', ' Top secret :)');
        $this->getModel()->set('info', 'Cowsay for the best :)');
    }
    
    
}