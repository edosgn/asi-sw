<?php

namespace JHWEB\DocumentoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('JHWEBDocumentoBundle:Default:index.html.twig', array('name' => $name));
    }
}
