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
    
}