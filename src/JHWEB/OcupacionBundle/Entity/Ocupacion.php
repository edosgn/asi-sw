<?php

namespace JHWEB\OcupacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ocupacion
 *
 * @ORM\Table(name="ocupacion")
 * @ORM\Entity
 */
class Ocupacion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=10)
     */
    private $codigo;

    /**
     * @var integer
     *
     * @ORM\Column(name="categoria", type="integer", length=2)
     */
    private $integer;

    /**
    * @ORM\OneToMany(targetEntity="JHWEB\UsuarioBundle\Entity\Usuario", mappedBy="ocupacion")
    * @ORM\OrderBy({"nombre" = "ASC"})
    */
    private $usuarios;

    public function __construct() {
        $this->usuarios = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * Set nombre
     *
     * @param string $nombre
     * @return Ocupacion
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
     * Set codigo
     *
     * @param string $codigo
     * @return Ocupacion
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set integer
     *
     * @param integer $integer
     * @return Ocupacion
     */
    public function setInteger($integer)
    {
        $this->integer = $integer;

        return $this;
    }

    /**
     * Get integer
     *
     * @return integer 
     */
    public function getInteger()
    {
        return $this->integer;
    }

    /**
     * Add usuarios
     *
     * @param \JHWEB\UsuarioBundle\Entity\Usuario $usuarios
     * @return Ocupacion
     */
    public function addUsuario(\JHWEB\UsuarioBundle\Entity\Usuario $usuarios)
    {
        $this->usuarios[] = $usuarios;

        return $this;
    }

    /**
     * Remove usuarios
     *
     * @param \JHWEB\UsuarioBundle\Entity\Usuario $usuarios
     */
    public function removeUsuario(\JHWEB\UsuarioBundle\Entity\Usuario $usuarios)
    {
        $this->usuarios->removeElement($usuarios);
    }

    /**
     * Get usuarios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }
}
