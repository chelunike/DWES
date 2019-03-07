<?php
namespace izv\mvc;

//use izv\mvc\Route;
use izv\app\App;
use izv\tools\Reader;

 /**
  * 
  **/
class Router {
    
    
    /**
     * Metodo estatico para procesar la url
     * 
     */
    static function preProcessor($url) {
        $result = [];
        $parametros = Reader::read('params');
        $result['ruta'] = '';
        $result['accion'] = '';
        $result['params'] = array();
        if($parametros !== null) {
            $parts = explode('/', $parametros);
            if(isset($parts[0])) {
                $result['ruta'] = $parts[0];        
            }
            if(isset($parts[1])) {
                $result['accion'] = $parts[1];
            }
            $result['params'] = array_slice($parts, 2);
        }
        return $result;
    }
    
    static function proccessParams($params, $names) {
        $result = array();
        $name = '';
        foreach($params as $i=>$part) {
            if( in_array($part, $names) ) {
                $name = $part;
            } else if( $name !== '' && $name !== $part) {
                $result[$name] = $part;
                $name = '';
            } else
                $params[] = $part;
        }
        return $result;
    }
    
    /**
     * Variables de instancia o Atributos
     */
    
    private $rutas;
    private $ruta;
    
    function __construct($ruta) {
        $this->rutas = array(
            'index' => new Route('DashModel', 'MainView', 'MainController'),
            'dashboard' => new Route('DashModel', 'DashView', 'DashController', array('type')),
            'user'  => new Route('UserModel', 'UserView', 'UserController'),
            'ajax'  => new Route('DashModel', 'AjaxView', 'AjaxController', array('type')),
            'file'  => new Route('FileModel', 'FileView', 'FileController')
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