<?php

namespace izv\data;

use izv\tools\Tools;

 /**
  * Usuario Bulgaris o Root
  * 
  * @Entity @Table(name="usuario")
 **/
class Usuario{
    
    use \izv\common\Comun;
    
    /**
     * @Id
     * @Column(type="bigint") @GeneratedValue
     */
    private $id; 
    
    /**
     * @Column(type="string", length=255, unique=true, nullable=false)
     */
    private $correo;
    
    /**
     * @Column(type="string", length=255, unique=true, nullable=false)
     */
    private $alias;
    
    /**
     * @Column(type="string", length=255, unique=false, nullable=false)
     */
    private $nombre;
    
    /**
     * @Column(type="string", length=255, unique=true, nullable=false)
     */
    private $clave;
    
    /**
     * @Column(type="boolean", length=255, unique=false, nullable=false)
     */
    private $activo = 0;
    
    /**
     * @Column(type="boolean", length=255, unique=false, nullable=false)
     */
    private $administrador = 0;
    
    /**
     * @Column(type="datetime", unique=false, nullable=false, columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP")
     */
    private $fechaalta;
    
    
    function __construct($id=null, $correo='', $alias='', $nombre="", $clave='', $activo=false, $fechaalta=null, $administrador=0){
        $this->id = $id;
        $this->correo = $correo; 
        $this->alias = $alias;
        $this->nombre = $nombre;
        $this->clave = $clave;
        $this->activo = $activo;
        $this->fechaalta = $fechaalta;
        $this->administrador = $administrador;
    }
    
    
    // Get y Set

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set correo
     *
     * @param string $correo
     *
     * @return Usuario
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set alias
     *
     * @param string $alias
     *
     * @return Usuario
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Usuario
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set clave
     *
     * @param string $clave
     *
     * @return Usuario
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Usuario
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set administrador
     *
     * @param boolean $administrador
     *
     * @return Usuario
     */
    public function setAdministrador($administrador)
    {
        $this->administrador = $administrador;

        return $this;
    }

    /**
     * Get administrador
     *
     * @return boolean
     */
    public function getAdministrador()
    {
        return $this->administrador;
    }

    /**
     * Set fechaalta
     *
     * @param \DateTime $fechaalta
     *
     * @return Usuario
     */
    public function setFechaalta($fechaalta)
    {
        $this->fechaalta = $fechaalta;

        return $this;
    }

    /**
     * Get fechaalta
     *
     * @return \DateTime
     */
    public function getFechaalta()
    {
        return $this->fechaalta->format('d-m-Y H:i:s');
    }
}