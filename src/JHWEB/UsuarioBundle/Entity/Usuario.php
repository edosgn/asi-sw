<?php

namespace JHWEB\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity
 * @UniqueEntity(fields={"identificacion"},message="Esta Identificación ya esta siendo usada.")
 */
class Usuario implements UserInterface
{
    function eraseCredentials()
    {
    }

    function getRoles()
    {
        $varRole=$this->getRole();
        return array($varRole);
    }

    function getUsername()
    {
        return $this->getIdentificacion();
    }
    /**
     * Set role
     *
     * @param string $role
     * @return Usuario
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
    * Set password
    *
    * @param string $password
    * @return Usuario
    */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Usuario
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="identificacion", type="integer")
     */
    private $identificacion;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=255)
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=255)
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="genero", type="string", length=10)
     */
    private $genero;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
     */
    private $fechaNacimiento;

    /**
     * @var integer
     *
     * @ORM\Column(name="fijo", type="integer")
     */
    private $fijo;

    /**
     * @var integer
     *
     * @ORM\Column(name="celular", type="integer")
     */
    private $celular;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="ubicacion", type="string", length=255)
     */
    private $ubicacion;

    /**
     * @var string
     *
     * @ORM\Column(name="fotografia", type="string", length=50, nullable=true)
     * @Assert\File(
     *     maxSize = "2048k",
     *     mimeTypes = {
     *          "image/jpeg",
     *          "image/jpg"
     *     },
     *     mimeTypesMessage = "Solo se aceptan formatos jpeg, jpg")
     */
    private $fotografia;

    /**
     * @var string
     *
     * @ORM\Column(name="afiliacion", type="string", length=50, nullable=true)
     * @Assert\File(
     *     maxSize = "2048k",
     *     mimeTypes = {
     *          "image/jpeg",
     *          "image/jpg"
     *     },
     *     mimeTypesMessage = "Solo se aceptan formatos jpeg, jpg")
     */
    private $afiliacion;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=50)
     */
    private $correo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_expedicion", type="date", nullable=true)
     */
    private $fechaExpedicion;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=50)
     */
    private $titulo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_solicitud", type="date", nullable=true)
     */
    private $fechaSolicitud;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=20)
     */
    private $estado;

    /**
     * @var boolean
     *
     * @ORM\Column(name="acepta", type="boolean")
     */
    private $acepta;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=50)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

    /** @ORM\ManyToOne(targetEntity="JHWEB\EtniaBundle\Entity\Etnia", inversedBy="usuarios") */
    protected $etnia;

    /** @ORM\ManyToOne(targetEntity="JHWEB\EscolaridadBundle\Entity\Escolaridad", inversedBy="usuarios") */
    protected $escolaridad;

    /** @ORM\ManyToOne(targetEntity="JHWEB\OcupacionBundle\Entity\Ocupacion", inversedBy="usuarios") */
    protected $ocupacion;

    /**
     * @ORM\ManyToMany(targetEntity="JHWEB\InteresBundle\Entity\Interes", mappedBy="usuarios")
     */
    private $intereses;

    /**
     * @ORM\ManyToMany(targetEntity="JHWEB\GrupoBundle\Entity\Grupo", mappedBy="usuarios")
     */
    private $grupos;

    public function __construct() {
        $this->intereses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->grupos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /** @ORM\ManyToOne(targetEntity="JHWEB\MunicipioBundle\Entity\Municipio", inversedBy="usuariosResidencia") */
    protected $municipioResidencia;

    /** @ORM\ManyToOne(targetEntity="JHWEB\MunicipioBundle\Entity\Municipio", inversedBy="usuariosNacimiento") */
    protected $municipioNacimiento;

    /** @ORM\ManyToOne(targetEntity="JHWEB\MunicipioBundle\Entity\Municipio", inversedBy="usuariosExpedicion") */
    protected $municipioExpedicion;

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
     * Set identificacion
     *
     * @param integer $identificacion
     * @return Usuario
     */
    public function setIdentificacion($identificacion)
    {
        $this->identificacion = $identificacion;

        return $this;
    }

    /**
     * Get identificacion
     *
     * @return integer 
     */
    public function getIdentificacion()
    {
        return $this->identificacion;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     * @return Usuario
     */
    public function setNombres($nombres)
    {
        $this->nombres = strtoupper($nombres);

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string 
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     * @return Usuario
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = strtoupper($apellidos);

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set genero
     *
     * @param string $genero
     * @return Usuario
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get genero
     *
     * @return string 
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return Usuario
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime 
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set fijo
     *
     * @param integer $fijo
     * @return Usuario
     */
    public function setFijo($fijo)
    {
        $this->fijo = $fijo;

        return $this;
    }

    /**
     * Get fijo
     *
     * @return integer 
     */
    public function getFijo()
    {
        return $this->fijo;
    }

    /**
     * Set celular
     *
     * @param integer $celular
     * @return Usuario
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return integer 
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Usuario
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }
    
    /**
     * Set ubicacion
     *
     * @param string $ubicacion
     * @return Usuario
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    /**
     * Get ubicacion
     *
     * @return string 
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     * Set fotografia
     *
     * @param string $fotografia
     * @return Usuario
     */
    public function setFotografia($fotografia)
    {
        $this->fotografia = $fotografia;

        return $this;
    }

    /**
     * Get fotografia
     *
     * @return string 
     */
    public function getFotografia()
    {
        return $this->fotografia;
    }

    /**
     * Set afiliacion
     *
     * @param string $afiliacion
     * @return Usuario
     */
    public function setAfiliacion($afiliacion)
    {
        $this->afiliacion = $afiliacion;

        return $this;
    }

    /**
     * Get afiliacion
     *
     * @return string 
     */
    public function getAfiliacion()
    {
        return $this->afiliacion;
    }

    /**
     * Set correo
     *
     * @param string $correo
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
     * Set fechaExpedicion
     *
     * @param \DateTime $fechaExpedicion
     * @return Usuario
     */
    public function setFechaExpedicion($fechaExpedicion)
    {
        $this->fechaExpedicion = $fechaExpedicion;

        return $this;
    }

    /**
     * Get fechaExpedicion
     *
     * @return \DateTime 
     */
    public function getFechaExpedicion()
    {
        return $this->fechaExpedicion;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Usuario
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set fechaSolicitud
     *
     * @param \DateTime $fechaSolicitud
     * @return Usuario
     */
    public function setFechaSolicitud($fechaSolicitud)
    {
        $this->fechaSolicitud = $fechaSolicitud;

        return $this;
    }

    /**
     * Get fechaSolicitud
     *
     * @return \DateTime 
     */
    public function getFechaSolicitud()
    {
        return $this->fechaSolicitud;
    }

    
    /**
     * Set etnia
     *
     * @param \JHWEB\EtniaBundle\Entity\Etnia $etnia
     * @return Usuario
     */
    public function setEtnia(\JHWEB\EtniaBundle\Entity\Etnia $etnia = null)
    {
        $this->etnia = $etnia;

        return $this;
    }

    /**
     * Get etnia
     *
     * @return \JHWEB\EtniaBundle\Entity\Etnia 
     */
    public function getEtnia()
    {
        return $this->etnia;
    }

    /**
     * Set escolaridad
     *
     * @param \JHWEB\EscolaridadBundle\Entity\Escolaridad $escolaridad
     * @return Usuario
     */
    public function setEscolaridad(\JHWEB\EscolaridadBundle\Entity\Escolaridad $escolaridad = null)
    {
        $this->escolaridad = $escolaridad;

        return $this;
    }

    /**
     * Get escolaridad
     *
     * @return \JHWEB\EscolaridadBundle\Entity\Escolaridad 
     */
    public function getEscolaridad()
    {
        return $this->escolaridad;
    }

    /**
     * Set ocupacion
     *
     * @param \JHWEB\OcupacionBundle\Entity\Ocupacion $ocupacion
     * @return Usuario
     */
    public function setOcupacion(\JHWEB\OcupacionBundle\Entity\Ocupacion $ocupacion = null)
    {
        $this->ocupacion = $ocupacion;

        return $this;
    }

    /**
     * Get ocupacion
     *
     * @return \JHWEB\OcupacionBundle\Entity\Ocupacion 
     */
    public function getOcupacion()
    {
        return $this->ocupacion;
    }

    /**
     * Add intereses
     *
     * @param \JHWEB\InteresBundle\Entity\Interes $intereses
     * @return Usuario
     */
    public function addInterese(\JHWEB\InteresBundle\Entity\Interes $intereses)
    {
        $this->intereses[] = $intereses;

        return $this;
    }

    /**
     * Remove intereses
     *
     * @param \JHWEB\InteresBundle\Entity\Interes $intereses
     */
    public function removeInterese(\JHWEB\InteresBundle\Entity\Interes $intereses)
    {
        $this->intereses->removeElement($intereses);
    }

    /**
     * Get intereses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIntereses()
    {
        return $this->intereses;
    }

    /**
     * Add grupos
     *
     * @param \JHWEB\GrupoBundle\Entity\Grupo $grupos
     * @return Usuario
     */
    public function addGrupo(\JHWEB\GrupoBundle\Entity\Grupo $grupos)
    {
        $this->grupos[] = $grupos;

        return $this;
    }

    /**
     * Remove grupos
     *
     * @param \JHWEB\GrupoBundle\Entity\Grupo $grupos
     */
    public function removeGrupo(\JHWEB\GrupoBundle\Entity\Grupo $grupos)
    {
        $this->grupos->removeElement($grupos);
    }

    /**
     * Get grupos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGrupos()
    {
        return $this->grupos;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return Usuario
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }
    
    /**
     * Set acepta
     *
     * @param boolean $acepta
     * @return Usuario
     */
    public function setAcepta($acepta)
    {
        $this->acepta = $acepta;

        return $this;
    }

    /**
     * Get acepta
     *
     * @return boolean 
     */
    public function getAcepta()
    {
        return $this->acepta;
    }

    /**
     * Set municipioResidencia
     *
     * @param \JHWEB\MunicipioBundle\Entity\Municipio $municipioResidencia
     * @return Usuario
     */
    public function setMunicipioResidencia(\JHWEB\MunicipioBundle\Entity\Municipio $municipioResidencia = null)
    {
        $this->municipioResidencia = $municipioResidencia;

        return $this;
    }

    /**
     * Get municipioResidencia
     *
     * @return \JHWEB\MunicipioBundle\Entity\Municipio 
     */
    public function getMunicipioResidencia()
    {
        return $this->municipioResidencia;
    }

    /**
     * Set municipioNacimiento
     *
     * @param \JHWEB\MunicipioBundle\Entity\Municipio $municipioNacimiento
     * @return Usuario
     */
    public function setMunicipioNacimiento(\JHWEB\MunicipioBundle\Entity\Municipio $municipioNacimiento = null)
    {
        $this->municipioNacimiento = $municipioNacimiento;

        return $this;
    }

    /**
     * Get municipioNacimiento
     *
     * @return \JHWEB\MunicipioBundle\Entity\Municipio 
     */
    public function getMunicipioNacimiento()
    {
        return $this->municipioNacimiento;
    }

    /**
     * Set municipioExpedicion
     *
     * @param \JHWEB\MunicipioBundle\Entity\Municipio $municipioExpedicion
     * @return Usuario
     */
    public function setMunicipioExpedicion(\JHWEB\MunicipioBundle\Entity\Municipio $municipioExpedicion = null)
    {
        $this->municipioExpedicion = $municipioExpedicion;

        return $this;
    }

    /**
     * Get municipioExpedicion
     *
     * @return \JHWEB\MunicipioBundle\Entity\Municipio 
     */
    public function getMunicipioExpedicion()
    {
        return $this->municipioExpedicion;
    }
}
