<?php
namespace izv\model;

use izv\app\App;
use izv\database\Doctrine;
use izv\data\User;
use izv\tools\Tools;
use izv\tools\Mail;
use izv\tools\Pagination;
use Doctrine\ORM\Tools\Pagination\Paginator;


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
        $usuario = $gestor->getRepository('izv\data\User')->findOneBy(array('mail' => $user)); 
        if(!isset($usuario)) {
            $usuario = $gestor->getRepository('izv\data\User')->findOneBy(array('nickname' => $user)); 
        }
        
        if(isset($usuario) && $usuario->getActive()===true && Tools::verificarClave($passwd, $usuario->getPassword())) {
            return $usuario;
        }
        return false;
    }
    
    function register($user) {
        
        // Encriptamos la clave
        $user->setPassword(Tools::encriptar($user->getPassword()));
        if(!Mail::sendActivation($user, App::BASE . 'user/activate')) {
            return false;
        }
        return $this->insert($user);
    }
    
    function activateUser($id) {
        if(isset($id) && is_numeric($id)) {
            $gestor = $this->getDoctrine()->getEntityManager();
            $user = $gestor->getRepository('izv\data\User')
                            ->findOneBy(array('id' => $id));
            if(!$user->getActive()) {
                try {
                    $user->setActive(true);
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
    
    function getUsers($pagina=1, $orden = 'id', $filtro = '') {
        $total = $this->getNumUsuarios();
        $gestor = $this->getDoctrine()->getEntityManager();
        
        $dql = 'select u from izv\data\User u order by u.'. $orden .', u.correo, u.alias, u.nombre, u.fechaalta';
        if(isset($filtro) && trim($filtro) !== '') {
            $dql = 'select u from izv\data\User u
                    where id like '.$filtro.' or u.alias like '.$filtro.' or u.correo like '.$filtro.' or u.nombre like '.$filtro.' or u.fechaalta like '.$filtro.'
                    order by u.'. $orden .', u.correo, u.alias, u.nombre, u.fechaalta';
            echo 'SI';
            
        }
        $paginacion = new Pagination($total, $pagina);
        $query = $gestor->createQuery($dql);
        $paginator = new Paginator($query);
        $limit = 10;
        $paginator->getQuery()
            ->setFirstResult($limit * ($pagina - 1))
            ->setMaxResults($limit);
        //return $paginator;
        $r = array();
        foreach($paginator as $user) {
            $r[] = $user->get();
        }
        return array(
            'users_list' => $r,
            'rango' => $paginacion->rango(),
            'pagination' => $paginacion->values(),
            'order' => $orden
        );
    }
    
    function getNumUsuarios() {
        $gestor = $this->getDoctrine()->getEntityManager();
        $users = $gestor->getRepository('izv\data\User')->findAll();
        return count($users);
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
    
    
    function addUser($user) {
        // Encriptamos la clave
        $user->setClave(Tools::encriptar($user->getClave()));
        return $this->add($user);
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
    
    
    function deleteMultiple($ids, $class) {
        $r = 0;
        foreach($ids as $id) {
            if($this->delete($id, $class) ) {
                $r++;
            }
        }
        return $r;
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