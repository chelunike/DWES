<?php
namespace izv\mvc;

 /**
  * 
 **/
class Route {
    
    /**
     */
    private $model, $view, $controller; 
    
    function __construct($model, $view, $controller){
        $this->model = $model;
        $this->view = $view; 
        $this->controller = $controller;
    }
    
    
    // Get y Set
    public function getModel() {
        return 'izv\model\\' . $this->model;
    }

    /**
     * Set view
     *
     * @param string $view
     */
    public function setView($view) {
        $this->view = $view;
        return $this;
    }

    /**
     * Get view
     *
     * @return string
     */
    public function getView() {
        return 'izv\view\\' . $this->view;
    }

    /**
     * Set controller
     *
     * @param string $controller
     */
    public function setController($controller) {
        $this->controller = $controller;
        return $this;
    }

    public function getController() {
        return 'izv\controller\\' . $this->controller;
    }

}