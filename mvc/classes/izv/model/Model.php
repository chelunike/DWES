<?php
namespace izv\model;

use izv\database\Database;

/**
 * El modelo siempre accede a la base de datos
 * Luego hay que automatizar esos accesos
 * 
 * 
 */
class Model {

    private $db, $viewData = array();

    function __construct() {
        $this->db = new Database();
        $this->viewData = array();
    }
    
    function get($name) {
        $result = null;
        if(isset($this->viewData[$name])) {
            $result = $this->viewData[$name];
        }
        return $result;
    }
    
    function getViewData() {
        return $this->viewData;
    }
    
    function getDatabase() {
        return $this->db;
    }
    
    function set($name, $value) {
        $this->viewData[$name] =  $value;
        return $this;
    }
    
    function add(array $array) {
        foreach($array as $indice => $valor) {
            $this->set($indice, $valor);
        }
    }
    
    function __destruct() {
        $this->db->close();
    }
}