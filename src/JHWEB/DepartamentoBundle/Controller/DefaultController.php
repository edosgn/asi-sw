<?php

namespace JHWEB\DepartamentoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('JHWEBDepartamentoBundle:Default:index.html.twig', array('name' => $name));
    }
}
