<?php

/**
 *  La clase de la conexion con base de datos
 * 
 * @author yo
 */
class Database {
    
    //Atributos
    private $host,
            $user,
            $password,
            $database,
            $connection;
    
    // Constructor
    function __construct($user = null, $password = null, $database = null, $host='localhost') {
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->host = $host;
        
        if($user === null){
            $this->user = App::USER;
            $this->password = App::PASSWORD;
            $this->database = App::DATABASE;
            $this->host = App::HOST;
        }
    }
    
    
    function connect(){
        $result = false;
        try {
            $this->connection = new PDO(
              'mysql:host=' . $this->host . ';dbname=' . $this->database,
              $this->user,
              $this->password,
              array(
                PDO::ATTR_PERSISTENT => true,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8')
            );
            
            $result = true;
        } catch(PDOException $e) {
            //echo $e->getMessage();
            //echo '<pre>' . var_export($this->connection->errorInfo(), true) . '</pre>';
        }
        return $result;
    }


    function close(){
        $this->connection = null;
    }
    
    // Get y Set
    
    function getConnection(){
        return $this->connection;
    }
    
}