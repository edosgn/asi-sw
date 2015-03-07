<?php
namespace JHWEB\UsuarioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use JHWEB\UsuarioBundle\Entity\Usuario;

class Usuarios extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    public function getOrder()
    {
        return 1;
    }

    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $usuario = new Usuario();
        $usuario->setIdentificacion(123456);
        $usuario->setNombres('root');
        $usuario->setApellidos('');
        $usuario->setGenero('M');
        $usuario->setFijo(0);
        $usuario->setCelular(0);
        $usuario->setDireccion('');
        $usuario->setRole('ROLE_SUPERADMIN');
        $usuario->setCorreo('info@jhwebpasto.com');
        $usuario->setTitulo('');
        $usuario->setAcepta('Si');
        $usuario->setEstado('Activo');

        $passwordEnClaro = 'admin123';
        $salt = (base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($usuario);
        $password = $encoder->encodePassword($passwordEnClaro, $salt);

        $usuario->setPassword($password);
        $usuario->setSalt($salt);

        $manager->persist($usuario);
        $manager->flush();
    }
}