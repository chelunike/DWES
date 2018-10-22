<?php
namespace izvdwes\tools;

/**
 * @author yo
 */
class Reader {
    
    
    
    private function _construct(){
    }
    
    //Metodos
    /**
     *  Si no me llegua el parametro con el nombre 
     * @return null En caso nada
     */
    static function get($name){
        return self::_read($name, $_GET);
    }
    /*
    static function get($name){
        if(isset($_GET[$name])){
            return $_GET[$name];
        }
        return null;
    }
     Version Uni
    static function get($name){
        $result = null;
        if(isset($_GET[$name])){
            $result = $_GET[$name];
        }
        return $result;
    }
    static function get($name, $array = $_GET){
        if(isset($array[$name])){
            return $array[$name];
        }
        return null;
    }
    */
    
    /**
     *  Si no me llegua el parametro con el nombre 
     * @return null En caso de nada 
     */
    static function post($name){
        return self::_read($name, $_POST);
    }
    /*
    static function post($name){
        if(isset($_POST[$name])){
            return $_POST[$name];
        }
        return null;
    }
    /* Version Uni
    static function post($name){
        $result = null;
        if(isset($_POST[$name])){
            $result = $_POST[$name];
        }
        return $result;
    }
    static function post($name, array $array = $_POST){
        if(isset($array[$name])){
            return $array[$name];
        }
        return null;
    }
    */
    
    function read($name){
        $result = self::get($name);
        if($result === null){
            $result = self::post($name);
        }
        return $result;
    }
    
    private function _read($name, array $array){
        if(isset($array[$name])){
            return trim($array[$name]);
        }
        return null;
    }
    
    /**
     * Metodo que lee el objeto e inserta Valores
     * @param string nombreClase
     * @param string nombreMetodo que devuelve el array de atributos
     * @param string nombreMetodo que inserta desde un array al objeto
     * 
     * @return object objeto de la clase
     */
    function readObject($class, $metodoGet = 'get', $metodoInsertArray = 'set'){
        $obj = null;
        if(class_exists($class)){
            $obj = new $class();
            
            if(method_exists($obj, $metodoGet)){
                $array = $obj->$metodoGet();
                
                foreach($array as $atributo => $value){
                    $array[$atributo] = self::read($atributo);
                }
                
                if(method_exists($obj, $metodoInsertArray)){
                    $obj->$metodoInsertArray($array);
                }
            }
        }
        return $obj;
    }
    

    static function readableObject(Readable $obj){
        $array = $obj->readableGet();
        
        foreach($array as $atributo => $value){
            $array[$atributo] = self::read($atributo);
        }
        $obj->readableSet($array);
        return $obj;
    }
    
    function count($method = null){
        if($method === null){
            $count = count($_GET) + count($_POST);
        }else if($method == 'get'){
            $count = count($_GET);
        }else{
            $count = count($_POST);
        }
        return $count;
    }
    
}
