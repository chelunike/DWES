<?php
namespace izv\model;

use izv\app\App;
use izv\database\Doctrine;
use izv\data\User;
use izv\tools\Tools;
use izv\tools\Mail;

/**
 * El modelo siempre accede a la base de datos
 * Luego hay que automatizar esos accesos
 * 
 * 
 */
class UserModel extends DoctrineModel {

    function login($user, $passwd) {
        $gestor = $this->getDoctrine()->getEntityManager();
        
        // Buscamos primero por correo
        $usuario = $gestor->getRepository('izv\data\User')->findOneBy(array('correo' => $user)); 
        if(!isset($usuario)) {
            $usuario = $gestor->getRepository('izv\data\User')->findOneBy(array('alias' => $user)); 
        }
        
        if(isset($usuario) && $usuario->getActivo()===true && Tools::verificarClave($passwd, $usuario->getClave())) {
            return $usuario;
        }
        return false;
    }
    
    function register($user) {
        $gestor = $this->getDoctrine()->getEntityManager();
        
        // Encriptamos la clave
        $user->setClave(Tools::encriptar($user->getClave()));
        try {
            $gestor->persist($user);
            $gestor->flush();
            // Enviamos email
            if(!Mail::sendActivation($user, App::BASE . 'user/activate')) {
                return false;
            }
            return true;
        } catch(\Exception $e) {
            return false;
        }
    }
    
    function activateUser($id) {
        if(isset($id) && is_numeric($id)) {
            $gestor = $this->getDoctrine()->getEntityManager();
            $user = $gestor->getRepository('izv\data\User')
                            ->findOneBy(array('id' => $id));
            if(!$user->getActivo()) {
                $user->setActivo(true);
                try {
                    $gestor->flush();
                    return true;
                } catch(Exception $e) {
                }
            }
        }
        return false;
    }
    
    function getUsersList() {
        $gestor = $this->getDoctrine()->getEntityManager();
        return $gestor->getRepository('izv\data\User')->findAll(); 
    }
    
    function getUser($id) {
        $gestor = $this->getDoctrine()->getEntityManager();
        return $gestor->find('izv\data\User', $id);
    }
    
    function deleteUser($id) {
        $gestor = $this->getDoctrine()->getEntityManager();
        $user = $gestor->find('izv\data\User', $id);
        try {
            $gestor->remove($user);
            $gestor->flush();
            return true;
        } catch(Exception $e) {
            return false;
        }
    }
    
    function deleteUsers($ids) {
        $r = 0;
        foreach($ids as $id) {
            if($this->deleteUser($id) ) {
                $r++;
            }
        }
        return $r;
    }
    
}