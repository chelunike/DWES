<?php

namespace izv\manager;

use \izv\data\Usuario;

class ManagerUsuario2 {

	private $em;

	function __construct(EntityManager $em) {
		$this->em = $em;
	}

	function add(Usuario $usuario) {
		$resultado = 0;
		try {

			$this->em-> ;
			$this->em->flush();
		} catch (Exception $e) {
			//echo $e->getMessage(); 
		}
		
	}

	function edit(Usuario $usuario) {
		$resultado = false;
		
		return $resultado;
	}

	function editWithPassword(Usuario $usuario) {
		$resultado = false;
		
		return $resultado;
	}
	
	function get($id) {
		$usuario = null;
		
		return $usuario;
	}

	function getAll() {
		$array = array();
		
		return $array;
	}

	/**
	 * A Mudarse esta funcion
	*/
	function login($correo, $clave) {
		if($this->em->connect()) {
			$sql = 'select * from usuario where correo = :correo';
			$array = array('correo' => $correo);
			if($this->em->execute($sql, $array)) {
				if($fila = $this->em->getSentence()->fetch()) {
					$usuario = new Usuario();
					$usuario->set($fila);
					$resultado = \izv\tools\Util::verificarClave($clave, $usuario->getClave());
					if($resultado) {
						$usuario->setClave('');
						return $usuario;
					}
				}
			}
		}
		return false;
	}
	
	function remove($id) {
		$resultado = 0;
		
		return $resultado;
	}
}