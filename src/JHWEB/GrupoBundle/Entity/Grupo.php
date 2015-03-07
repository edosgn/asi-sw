<?php

namespace JHWEB\GrupoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Grupo
 *
 * @ORM\Table(name="grupo")
 * @ORM\Entity
 */
class Grupo
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
     * @ORM\Column(name="detalle", type="text")
     */
    private $detalle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @ORM\ManyToMany(targetEntity="JHWEB\UsuarioBundle\Entity\Usuario", inversedBy="grupos")
     * @ORM\JoinTable(name="usuarios_grupos")
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
     * Set detalle
     *
     * @param string $detalle
     * @return Grupo
     */
    public function setDetalle($detalle)
    {
        $this->detalle = $detalle;

        return $this;
    }

    /**
     * Get detalle
     *
     * @return string 
     */
    public function getDetalle()
    {
        return $this->detalle;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Grupo
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Add usuarios
     *
     * @param \JHWEB\UsuarioBundle\Entity\Usuario $usuarios
     * @return Grupo
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
