<?php
namespace izv\mvc;

//use izv\mvc\Route;

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
            'indexa' => new Route('Model', 'View', 'Controller'),
            'indexaMio' => new Route('FirstModel', 'FirstView', 'FirstController'),
            'dashboard' => new Route('DashModel', 'DashView', 'DashController'),
            'admin' => new Route('AdminModel', 'AdminView' , 'AdminController'),
            'index' => new Route('FirstModel', 'MaundyView', 'UserController'),
            'zeta'  => new Route('FirstModel', 'SecondView', 'FirstController'),
            'user'  => new Route('UserModel', 'UserView', 'UserController'),
            //'ruta'  => new Route('modelo', 'vista', 'controlador'),
            'otra'  => new Route('', '', '')
        );
        $this->ruta = strtolower($ruta);
    }
    
    
    // Get y Set
    public function getRoute() {
        $ruta = $this->rutas['index'];
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