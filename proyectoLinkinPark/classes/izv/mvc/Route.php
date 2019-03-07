<?php

namespace izv\mvc;

// -- -- - Proceso de modificacion - -- --
 /**
  * 
 **/
class Route {
    
    /**
     * Variables de instancia
     */
    private $model, $view, $controller, $params; 
    
    function __construct($model, $view, $controller, $params = []) {
        $this->model = $model;
        $this->view = $view; 
        $this->controller = $controller;
        if(isset($params) && is_array($params)) {
            $this->params = $params;
        }
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

    /**
     * Get controller
     *
     * @return string
     */
    public function getController() {
        return 'izv\controller\\' . $this->controller;
    }
    
    /**
     * Get params
     *
     * @return array
     */
    public function getParams() {
        return $this->params;
    }

    /**
     * Set params
     *
     * @param array $params
     */
    public function setParams($params) {
        if(isset($params) && is_array($params)) {
            $this->params = $params;
        }
        return $this;
    }

}