<?php

namespace JHWEB\MunicipioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Municipio
 *
 * @ORM\Table(name="municipio")
 * @ORM\Entity
 */
class Municipio
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
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=10)
     */
    private $codigo;

    /** @ORM\ManyToOne(targetEntity="JHWEB\DepartamentoBundle\Entity\Departamento", inversedBy="municipios") */
    protected $departamento;

    /**
    * @ORM\OneToMany(targetEntity="JHWEB\UsuarioBundle\Entity\Usuario", mappedBy="municipioResidencia")
    * @ORM\OrderBy({"nombre" = "ASC"})
    */
    private $usuariosResidencia;

    /**
    * @ORM\OneToMany(targetEntity="JHWEB\UsuarioBundle\Entity\Usuario", mappedBy="municipioNacimiento")
    * @ORM\OrderBy({"nombre" = "ASC"})
    */
    private $usuariosNacimiento;

    /**
    * @ORM\OneToMany(targetEntity="JHWEB\UsuarioBundle\Entity\Usuario", mappedBy="municipioExpedicion")
    * @ORM\OrderBy({"nombre" = "ASC"})
    */
    private $usuariosExpedicion;

    public function __construct() {
        $this->usuariosResidencia = new \Doctrine\Common\Collections\ArrayCollection();
        $this->usuariosNacimiento = new \Doctrine\Common\Collections\ArrayCollection();
        $this->usuariosExpedicion = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Municipio
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
     * @return Municipio
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
     * Set departamento
     *
     * @param \JHWEB\DepartamentoBundle\Entity\Departamento $departamento
     * @return Municipio
     */
    public function setDepartamento(\JHWEB\DepartamentoBundle\Entity\Departamento $departamento = null)
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get departamento
     *
     * @return \JHWEB\DepartamentoBundle\Entity\Departamento 
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    public function __toString()
    {
        return $this->getNombre();
    }

    /**
     * Add usuariosResidencia
     *
     * @param \JHWEB\UsuarioBundle\Entity\Usuario $usuariosResidencia
     * @return Municipio
     */
    public function addUsuariosResidencium(\JHWEB\UsuarioBundle\Entity\Usuario $usuariosResidencia)
    {
        $this->usuariosResidencia[] = $usuariosResidencia;

        return $this;
    }

    /**
     * Remove usuariosResidencia
     *
     * @param \JHWEB\UsuarioBundle\Entity\Usuario $usuariosResidencia
     */
    public function removeUsuariosResidencium(\JHWEB\UsuarioBundle\Entity\Usuario $usuariosResidencia)
    {
        $this->usuariosResidencia->removeElement($usuariosResidencia);
    }

    /**
     * Get usuariosResidencia
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuariosResidencia()
    {
        return $this->usuariosResidencia;
    }

    /**
     * Add usuariosNacimiento
     *
     * @param \JHWEB\UsuarioBundle\Entity\Usuario $usuariosNacimiento
     * @return Municipio
     */
    public function addUsuariosNacimiento(\JHWEB\UsuarioBundle\Entity\Usuario $usuariosNacimiento)
    {
        $this->usuariosNacimiento[] = $usuariosNacimiento;

        return $this;
    }

    /**
     * Remove usuariosNacimiento
     *
     * @param \JHWEB\UsuarioBundle\Entity\Usuario $usuariosNacimiento
     */
    public function removeUsuariosNacimiento(\JHWEB\UsuarioBundle\Entity\Usuario $usuariosNacimiento)
    {
        $this->usuariosNacimiento->removeElement($usuariosNacimiento);
    }

    /**
     * Get usuariosNacimiento
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuariosNacimiento()
    {
        return $this->usuariosNacimiento;
    }

    /**
     * Add usuariosExpedicion
     *
     * @param \JHWEB\UsuarioBundle\Entity\Usuario $usuariosExpedicion
     * @return Municipio
     */
    public function addUsuariosExpedicion(\JHWEB\UsuarioBundle\Entity\Usuario $usuariosExpedicion)
    {
        $this->usuariosExpedicion[] = $usuariosExpedicion;

        return $this;
    }

    /**
     * Remove usuariosExpedicion
     *
     * @param \JHWEB\UsuarioBundle\Entity\Usuario $usuariosExpedicion
     */
    public function removeUsuariosExpedicion(\JHWEB\UsuarioBundle\Entity\Usuario $usuariosExpedicion)
    {
        $this->usuariosExpedicion->removeElement($usuariosExpedicion);
    }

    /**
     * Get usuariosExpedicion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuariosExpedicion()
    {
        return $this->usuariosExpedicion;
    }
}
