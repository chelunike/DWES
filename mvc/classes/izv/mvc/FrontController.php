<?php
namespace izv\mvc;

use izv\app\App;

 /**
  * Controlador Frontal
  * 
  **/
class FrontController {
	
	/**
	 * Variables de instancia o Atributos
	 */
	private $action;
	private $model, $view, $controller;
	
	function __construct($route, $accion) {
		$router = new Router($route);
		$route = $router->getRoute();
		$this->action = strtolower($accion);
		
		$model = $route->getModel();
		if(!class_exists($model)) {
			$model = App::DEFAULT_MODEL;
		}
		$this->model = new $model();
	
		$view = $route->getView();
		if(!class_exists($view)) {
			$view = App::DEFAULT_VIEW;
		}
		$this->view = new $view($this->model);
	
		$controller = $route->getController();
		if(!class_exists($controller)) {
			$controller = App::DEFAULT_CONTROLLER;
		}
		$this->controller = new $controller($this->model);    
	
	}
	
	function doAction() {
		$accion = 'action';
		if(method_exists($this->controller, $this->action)) {
			$accion = $this->action;
		}
		return $this->controller->$accion();
	}
	
	function render() {
		return $this->view->render($this->action);
	}
	
	
	// Get y Set
	public function getRoute() {
		$route = null;
		if(isset($this->routes[$this->route])) {
			$route = $this->routes[$this->route];
		}
		return $route;
	}

}