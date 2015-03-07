<?php

namespace JHWEB\DepartamentoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Departamento
 *
 * @ORM\Table(name="departamento")
 * @ORM\Entity
 */
class Departamento
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

    /**
     * @var string
     *
     * @ORM\Column(name="indicativo", type="string", length=10)
     */
    private $indicativo;

    /**
    * @ORM\OneToMany(targetEntity="JHWEB\MunicipioBundle\Entity\Municipio", mappedBy="departamento")
    * @ORM\OrderBy({"nombre" = "ASC"})
    */
    private $municipios;

    public function __construct() {
        $this->municipios = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Departamento
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
     * @return Departamento
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
     * Set indicativo
     *
     * @param string $indicativo
     * @return Departamento
     */
    public function setIndicativo($indicativo)
    {
        $this->indicativo = $indicativo;

        return $this;
    }

    /**
     * Get indicativo
     *
     * @return string 
     */
    public function getIndicativo()
    {
        return $this->indicativo;
    }

    /**
     * Add municipios
     *
     * @param \JHWEB\MunicipioBundle\Entity\Municipio $municipios
     * @return Departamento
     */
    public function addMunicipio(\JHWEB\MunicipioBundle\Entity\Municipio $municipios)
    {
        $this->municipios[] = $municipios;

        return $this;
    }

    /**
     * Remove municipios
     *
     * @param \JHWEB\MunicipioBundle\Entity\Municipio $municipios
     */
    public function removeMunicipio(\JHWEB\MunicipioBundle\Entity\Municipio $municipios)
    {
        $this->municipios->removeElement($municipios);
    }

    /**
     * Get municipios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMunicipios()
    {
        return $this->municipios;
    }
}
