<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new JHWEB\UsuarioBundle\JHWEBUsuarioBundle(),
            new JHWEB\EtniaBundle\JHWEBEtniaBundle(),
            new JHWEB\DepartamentoBundle\JHWEBDepartamentoBundle(),
            new JHWEB\MunicipioBundle\JHWEBMunicipioBundle(),
            new JHWEB\EscolaridadBundle\JHWEBEscolaridadBundle(),
            new JHWEB\InteresBundle\JHWEBInteresBundle(),
            new JHWEB\OcupacionBundle\JHWEBOcupacionBundle(),
            new JHWEB\GrupoBundle\JHWEBGrupoBundle(),
            new JHWEB\DocumentoBundle\JHWEBDocumentoBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
