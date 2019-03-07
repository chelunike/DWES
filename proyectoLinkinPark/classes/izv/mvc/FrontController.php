<?php
namespace izv\mvc;

use izv\app\App;

 /**
  *  Controlador Frontal
  * 
  **/
class FrontController {
	
	/**
	 * Metodo estatico que realiza 
	 * todas las funciones basicas del tiron
	 */
	function initController($args = []) {
		$ruta = '';
		if (isset($args['ruta']))
			$ruta = $args['ruta'];
		$accion = '';
		if (isset($args['accion']))
			$accion = $args['accion'];
		$params = array();
		if (isset($args['params']))
			$params = $args['params'];
		
		// -- La Magia del Controlador Frontal --
		$frontController = new FrontController($ruta, $accion, $params);
		// -- Realizamos la accion correspondiente
		$frontController->doAction();
		
		// -- Respuesta del Controlador Frontal --
		echo $frontController->render();
		
	}
	
	
	/**
	 * Variables de instancia o Atributos
	 */
	private $action, $params;
	private $model, $view, $controller;
	
	function __construct($route, $accion, $params = null) {
		$router = new Router($route);
		$route = $router->getRoute();
		$this->action = strtolower($accion);
		
		$model = $route->getModel();
		$this->model = new $model();
	
		$view = $route->getView();
		$this->view = new $view($this->model);
	
		$controller = $route->getController();
		$this->controller = new $controller($this->model);    
		
		$this->params = array();
		if($params !== null && is_array($params)) {
			$this->params = Router::proccessParams($params, $route->getParams());
			// Se añaden todos los parametros
			$this->params = array_merge($_GET, $_POST, $this->params);
		}
		$this->params['action'] = $this->action;
	}
	
	function doAction() {
		$accion = 'action';
		if(method_exists($this->controller, $this->action)) {
			$accion = $this->action;
		}
		return $this->controller->$accion($this->params);
	}
	
	function render() {
		return $this->view->render($this->params);
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