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
    
    function getDoctrine() {
        return $this->doc;
    }
    
    function __destruct() {
    
    }
}