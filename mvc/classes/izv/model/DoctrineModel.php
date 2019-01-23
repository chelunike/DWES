<?php
namespace izv\model;

use izv\database\Doctrine;

/**
 * El modelo siempre accede a la base de datos
 * Luego hay que automatizar esos accesos
 * 
 * 
 */
class DoctrineModel extends Model {

    private $doc, $viewData = array();

    function __construct() {
        $this->doc = new Doctrine();
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
    
    
    function getDoctrine() {
        return $this->doc;
    }
    
    function set($name, $value) {
        $this->viewData[$name] =  $value;
        return $this;
    }
    
    function __destruct() {
        //$this->d/oc->close();
    }
}