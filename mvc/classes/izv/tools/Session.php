<?php

namespace izv\tools;


class Session {
    
    // Atributos - Variables de instancia
    private $name;

    // Constructor
    function __construct($name) {
        $this->name = trim($name);
        if(isset($this->name)) {
            session_name($this->name);
            session_start();
        }
    }
    
    function get($name) {
        if(isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return null;
    }
    
    function set($name, $value) {
        if(session_status() !== PHP_SESSION_NONE && isset($name) && isset($value)) {
            $_SESSION[$name] = $value;
        }
        return $this;
    }
    
    function destroy(){
        if (session_status() !== PHP_SESSION_NONE) {
            session_destroy();
        }
    }
    
    function getLogin($name='usuario') {
        if(session_status() !== PHP_SESSION_NONE && isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return null;
    }
    
    function isLogged($name='usuario') {
        return $this->getLogin($name) !== null;
    }
    
    function login($user, $name='usuario') {
        session_regenerate_id();
        return $this->set($name, $user);
    }
    
    function logout($name='usuario') {
        if (session_status() !== PHP_SESSION_NONE) {
            unset($_SESSION[$name]);
        }
        return $this;
    }
    
    function isRoot() {
        return $this->getLogin()->getAdministrador();
    }
    
}
