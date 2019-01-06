<?php
namespace izv\mvc;

//use izv\mvc\Route;
use izv\app\App;

 /**
  * 
  **/
class Router {
    
    /**
     * Variables de instancia o Atributos
     */
    
    private $rutas;
    private $ruta;
    
    function __construct($ruta) {
        $this->rutas = array(
            'index' => new Route('MainModel', 'MainView', 'MainController'),
            'dashboard' => new Route('DashModel', 'DashView', 'DashController'),
            'user'  => new Route('UserModel', 'UserView', 'UserController'),
            //'ruta'  => new Route('modelo', 'vista', 'controlador'),
        );
        $this->ruta = strtolower($ruta);
    }
    
    
    // Get y Set
    public function getRoute() {
        $ruta = $this->rutas[App::DEFAULT_ROUTE];
        if(isset($this->rutas[$this->ruta])) {
            $ruta = $this->rutas[$this->ruta];
        }
        return $ruta;
    }

    public function isExist() {
        if(isset($this->rutas[$this->ruta])) {
            return true;
        }
        return false;
    }

}