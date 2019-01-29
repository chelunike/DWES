<?php
namespace izv\model;

use izv\database\Database;
use izv\tools\Mail;
use izv\app\App;
use izv\tools\Tools;

/**
 * El modelo siempre accede a la base de datos
 * Luego hay que automatizar esos accesos
 * 
 * 
 */
class DashModel extends UserModel {

    function update() {
        try {
            $this->getDoctrine()->getEntityManager()->flush();
            return true;
        } catch(Exception $e) {
            //echo $e->getMessage();
            return false;
        }
    }
    
    function editCorreo($user, $newCorreo) {
        try {
            $oldCorreo = $user->getCorreo();
            // Cambiamos correo
            $user->setCorreo($newCorreo);
            $user->setActivo(false);
            // Actualizamos
            $this->getDoctrine()->getEntityManager()->flush();
            // Enviamos emails
            Mail::sendActivation($user, App::BASE . 'user/activate');
            Mail::sendMailChange($user, $oldCorreo);
            
            return true;
        } catch(Exception $e) {
            //echo $e->getMessage();
            return false;
        }
    }
    
    function editPasswd($user, $clave, $newClave) {
        try {
            // Comprobamos contraseña
            if(!Tools::verificarClave($clave, $user->getClave()))
                return false;
                
            $user->setClave(Tools::encriptar($newClave));
            $user->setActivo(false);
            // Actualizamos
            $this->getDoctrine()->getEntityManager()->flush();
            // Enviamos emails
            Mail::sendActivation($user, App::BASE . 'user/activate');
            
            return true;
        } catch(Exception $e) {
            //echo $e->getMessage();
            return false;
        }
    }
    
    function doDestruct($user, $partial) {
        try {
            $gestor = $this->getDoctrine()->getEntityManager();
            if($patial) {
                $user->setActivo(false);    
                Mail::sendActivation($user, App::BASE . 'user/activate');
            } else {
                $gestor->remove($user);
            }
            $gestor->flush();
            return true;
        } catch(Exception $e) {
            //echo $e->getMessage();
            return false;
        }
    }
    
    function insert($user) {
        $gestor = $this->getDoctrine()->getEntityManager();
        
        // Encriptamos la clave
        $user->setClave(Tools::encriptar($user->getClave()));
        
        try {
            $gestor->persist($user);
            $gestor->flush();
            return true;
        } catch(Exception $e) {
            //echo $e->getMessage();
            return false;
        }
    }
    
    function editUser($tmp) {
        $gestor = $this->getDoctrine()->getEntityManager();
        // Sacamamos user
        $user = $gestor->find('izv\data\User', $tmp->getId());
        if(isset($user)) {
            if($tmp->getCorreo() !== null) {
                $user->setCorreo($tmp->getCorreo());
            }
            if($tmp->getAlias() !== null) {
                $user->setAlias($tmp->getAlias());
            }
            if($tmp->getClave() !== null) {
                $user->setClave($tmp->getClave());
            }
            if($tmp->getActivo() !== null) {
                $user->setActivo($tmp->getActivo());
            }
            if($tmp->getAdministrador() !== null) {
                $user->setAdministrador($tmp->getAdministrador());
            }
            try {
                $gestor->flush();
                return true;
            } catch(Exception $e) {
                //echo $e->getMessage();
                
            } 
        }
        return false;
    }
    
    function editPicture($id, $picture) {
        $gestor = $this->getDoctrine()->getEntityManager();
        try {
            $user = $gestor->find('izv\data\User', $id);
            
            $user->setPicture($picture);
            
            $gestor->flush();
            return true;
        } catch(Exception $e) {
            //echo $e->getMessage();
            return false;
        }
    }
    
    
}