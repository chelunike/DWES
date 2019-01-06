<?php
namespace izv\mvc;


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
		$this->model = new $model();
	
		$view = $route->getView();
		$this->view = new $view($this->model);
	
		$controller = $route->getController();
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