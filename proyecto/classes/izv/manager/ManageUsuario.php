<?php

namespace izv\manager;

use \izv\database\Database;
use \izv\data\Usuario;

/**
 * @author yo
 */
class ManageUsuario {
    
    // Atributos o Variables de instancia
    private $db;
    
    //Constructor
    function __construct(Database $db=null) {
        $this->db = $db;
    }
    
    
    // Metodos
    
    /**
     * @return Id insertado
     */
    function add(Usuario $usuario) {
        $resultado = 0;
        if($this->db->connect() && $usuario !== null) {
            $sql = 'insert into usuario values (null, :correo, :alias, :nombre, :clave, :activo, null)';
            $data = array(
                'correo' => $usuario->getCorreo(), 
                'alias' => $usuario->getAlias(), 
                'nombre' => $usuario->getNombre(),
                'clave' => $usuario->getClave(),
                'activo' => $usuario->getActivo()
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
    function edit(Usuario $usuario) {
        $resultado = 0;
        if($this->db->connect()) {
            $sql = 'update usuario set correo = :correo, alias = :alias, nombre = :nombre, clave = :clave, activo = :activo where id = :id';
            $array = $usuario->get();
            unset($array['fechaalta']);
            if($this->db->execute($sql, $array)) {
                $resultado = $this->db->getSentence()->rowCount();
            }
        }
        return $resultado;
    }
    
    /**
     * @return Num filas borradas
     */
    function remove($id) {
        $resultado = 0;
        if($this->db->connect()) {
            $sql = 'delete from usuario where id = :id';
            if($this->db->execute($sql, array('id' => $id))) {
                $resultado = $this->db->getSentence()->rowCount();  
            }
        }
        return $resultado;
    }
    
    // Get 
    /**
     * @return Usuario con ese id
     */
    function get($id) {
        $usuario = null;
        if($this->db->connect()) {
            $sql = 'select * from usuario where id = :id';
            if($this->db->execute($sql, array('id' => $id))) {
                $sentencia = $this->db->getSentence();
                if($fila = $sentencia->fetch()) {
                    $usuario = new Usuario();
                    $usuario->set($fila);
                }
            }
        }
        return $usuario;
    }
    
    /**
     * @return Todos los objetos
     */
    function getAll() {
        $array = array();
        $sql = 'select * from usuario';
        if($this->db->connect() && $this->db->execute($sql)) {
            $sentencia = $this->db->getSentence();
            while($fila = $sentencia->fetch()) {
                $usuario = new Usuario();
                $usuario->set($fila);
                $array[] = $usuario;
            }
        }
        return $array;
    }
    
    
}