<?php

namespace izv\manager;

use \izv\database\Database;

/**
 * @author yo
 */
class Manage {
    
    // Atributos o Variables de instancia
    private $db,
            $table,
            $clase;
    
    //Constructor
    function __construct($class, $table, Database $db=null) {
        $this->db = $db;
        $this->table = $table;
        $this->clase = $class;
        
        $path = '../data/' . $class . '.php';
        if(file_exists($path)) {
            require $path;
        }
    }
    
    
    // Metodos
    
    /**
     * @return Id insertado
     */
    function add($producto) {
        $resultado = 0;
        if($this->db->connect() && $producto !== null) {
            $sql = 'insert into producto values(null, :nombre, :precio, :observaciones)';
            $data = array(
                'nombre' => $producto->getNombre(), 
                'precio' => $producto->getPrecio(),
                'observaciones' => $producto->getObservaciones()
            );
            if($this->db->execute($sql, $data)) {
                $resultado = $this->db->getConnection()->lastInsertId();   
            }
        }
        return $resultado;
    }
    
    /**
     * @return Num filas modificas
     */
    function edit(Producto $producto) {
        $resultado = 0;
        if($this->db->connect()) {
            $sql = 'update producto set nombre = :nombre, precio = :precio, observaciones = :observaciones where id = :id';
            if($this->db->execute($sql, $producto->get())) {
                $resultado = $this->db->getSentence()->rowCount();
            }
        }
        return $resultado;
    }
    /*function edit(Producto $p) {
        $resultado = 0;
        if($this->db->connect() && $p !== null) {
            $sql = 'update producto set nombre = :nombre, precio = :precio, observaciones = :observaciones  where id = :id';
            if($this->db->execute($sql, $p->get())) {
                $resultado = $this->db->getSentence()->rowCount();   
            }
        }
        return $resultado;
    }*/
    
    /**
     * @return Num filas borradas
     */
    function remove($id) {
        $resultado = 0;
        if($this->db->connect()) {
            $sql = 'delete from producto where id = :id';
            if($this->db->execute($sql, array('id' => $id))) {
                $resultado = $this->db->getSentence()->rowCount();  
            }
        }
        return $resultado;
    }
    
    // Get 
    /**
     * @return Producto con ese id
     */
    function get($id) {
        $producto = null;
        if($this->db->connect()) {
            $sql = 'select * from producto where id = :id';
            if($this->db->execute($sql, array('id' => $id))) {
                $sentencia = $this->db->getSentence();
                if($fila = $sentencia->fetch()) {
                    $producto = new Producto();
                    $producto->set($fila);
                }
            }
        }
        return $producto;
    }
    
    /**
     * @return Todos los objetos
     */
    function getAll() {
        $array = array();
        $sql = 'select * from producto';
        if($this->db->connect() && $this->db->execute($sql)) {
            $sentencia = $this->db->getSentence();
            while($fila = $sentencia->fetch()) {
                $producto = new Producto();
                $producto->set($fila);
                $array[] = $producto;
            }
        }
        return $array;
    }
    
    
}