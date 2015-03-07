<?php

namespace JHWEB\EtniaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etnia
 *
 * @ORM\Table(name="etnia")
 * @ORM\Entity
 */
class Etnia
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
    * @ORM\OneToMany(targetEntity="JHWEB\UsuarioBundle\Entity\Usuario", mappedBy="etnia")
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
     * @return Etnia
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
     * Add usuarios
     *
     * @param \JHWEB\UsuarioBundle\Entity\Usuario $usuarios
     * @return Etnia
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
