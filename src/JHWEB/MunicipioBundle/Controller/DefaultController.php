<?php

namespace JHWEB\MunicipioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('JHWEBMunicipioBundle:Default:index.html.twig', array('name' => $name));
    }
}
