<?php

namespace JHWEB\OcupacionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('JHWEBOcupacionBundle:Default:index.html.twig', array('name' => $name));
    }
}
