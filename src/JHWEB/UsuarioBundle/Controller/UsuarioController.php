<?php

namespace JHWEB\UsuarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JHWEB\UsuarioBundle\Entity\Usuario;
use JHWEB\UsuarioBundle\Form\UsuarioType;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Usuario controller.
 *
 * @Route("/usuario")
 */
class UsuarioController extends Controller
{
    /* Renderiza la vista para el formulario de logueo */
    public function loginAction()
    {
        $peticion = $this->getRequest();
        $sesion = $peticion->getSession();
        $error = $peticion->attributes->get(
            SecurityContext::AUTHENTICATION_ERROR,
            $sesion->get(SecurityContext::AUTHENTICATION_ERROR)
            );
        return $this->render('JHWEBUsuarioBundle:Usuario:login.html.twig', array(
            'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
            'error' => $error
            ));
    }
    public function registroAction()
    {
        $peticion = $this->getRequest();
        $usuario = new Usuario();
        $formulario = $this->createForm(new UsuarioType(), $usuario);
        
        if ($peticion->getMethod() == 'POST') {
            $formulario->bind($peticion);
            if ($formulario->isValid()) {
                /* === Recupera la identificacion digitada === */
                $identificacion=$formulario['identificacion']->getData();
                /* Captura los municipios seleccionados */
                $idMunicipioExpedicion=$peticion->get('municipio1');
                $idMunicipioNacimiento=$peticion->get('municipio2');
                $idMunicipioResidencia=$peticion->get('municipio3');
                /* === Valida si selecciono una nueva foto === */
                if ($formulario['fotografia']->getData()!=null) {
                    $extension = $formulario['fotografia']->getData()->guessExtension();
                    $filename = $identificacion.".".$extension;
                    $dir=__DIR__.'/../../../../web/bundles/styles/img/avatars';
                    $formulario['fotografia']->getData()->move($dir,$filename);
                    $usuario->setFotografia($filename);
                }
                
                $password = $this->createPassword();

                $encoder = $this->get('security.encoder_factory')->getEncoder($usuario);
                $usuario->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
                $passwordCodificado = $encoder->encodePassword($password,$usuario->getSalt());
                $usuario->setPassword($passwordCodificado);
                $usuario->setEstado('Pendiente');
                $usuario->setRole('ROLE_USER');

                $usuario->setFechaNacimiento(new \DateTime($peticion->get('fechaNacimiento')));
                $usuario->setFechaExpedicion(new \DateTime($peticion->get('fechaExpedicion')));
                $usuario->setFechaSolicitud(new \DateTime(date('Y-m-d')));

                $em = $this->getDoctrine()->getManager();
                $municipioExpedicion = $em->getRepository('JHWEBMunicipioBundle:Municipio')->find($idMunicipioExpedicion);
                $municipioNacimiento = $em->getRepository('JHWEBMunicipioBundle:Municipio')->find($idMunicipioNacimiento);
                $municipioResidencia = $em->getRepository('JHWEBMunicipioBundle:Municipio')->find($idMunicipioResidencia);
                
                $usuario->setMunicipioExpedicion($municipioExpedicion);
                $usuario->setMunicipioResidencia($municipioResidencia);
                $usuario->setMunicipioNacimiento($municipioNacimiento);


                //$em = $this->getDoctrine()->getManager();
                $em->persist($usuario);
                $em->flush();

                $message = \Swift_Message::newInstance()
                ->setSubject('Registro ASI')
                ->setFrom($usuario->getCorreo())
                ->setTo($usuario->getCorreo())
                ->setBody(
                    $this->renderView(
                        'JHWEBUsuarioBundle:Usuario:email.html.twig',
                        array(
                            'usuario' => $usuario,
                            'password' => $password
                            )
                    ), 'text/html'
                )
                ->setPriority(2);
                $this->get('mailer')->send($message);

                $this->get('session')->getFlashBag()->add( 'info','A su correo '.$usuario->getCorreo()." se ha enviado una contraseña, la cual puede cambiar desde el panel superior.");
                return $this->redirect($this->generateUrl('escritorio'));
            }
        }

        $em = $this->getDoctrine()->getManager();
        $departamentos = $em->getRepository('JHWEBDepartamentoBundle:Departamento')->findAll();

        return $this->render(
            'JHWEBUsuarioBundle:Usuario:registro.html.twig',
            array(
                'formulario' => $formulario->createView(),
                'usuario' => $usuario,
                'departamentos' => $departamentos,
                ));
    }

    /*  */
    public static function createPassword( $length = 5 )
    {
        $val = "";
        $values = "abcdefghijklmnopqrstuvwyz123456789";
        for ( $i = 0; $i < $length; $i++ )
        {
            $r = mt_rand( 0, 24 );
            $val = $val.$values[$r];
        }
        return $val;        
    }

    /* Renderiza la vista de inicio  */
    public function escritorioAction()
    {
        $usuario = $this->get('security.context')->getToken()->getUser();

        return $this->render('JHWEBUsuarioBundle:Usuario:escritorio.html.twig', array(
            'usuario' => $usuario
        ));
    }
    /* Renderiza la vista inicial  */
    public function inicioAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usuarios = $em->getRepository('JHWEBUsuarioBundle:Usuario')->findAll();

        return $this->render('JHWEBUsuarioBundle:Usuario:inicio.html.twig', array(
                    'usuarios' => $usuarios
                ));
    }

    /* Renderiza la vista de municipios segun departamento  */
    public function listaMunicipiosAction($idDepartamento,$tipo)
    {
        $em = $this->getDoctrine()->getManager();
        $municipios = $em->getRepository('JHWEBMunicipioBundle:Municipio')->findByDepartamento($idDepartamento);

        return $this->render('JHWEBUsuarioBundle:Usuario:listaMunicipios.html.twig', array(
                    'municipios' => $municipios,
                    'tipo' => $tipo,
                ));
    }

    /**
     * 
     * @Route("/impresion/formulario/{id}", name="usuario_imprimir_informacion")
     */

    public function imprimirInformacion($id){

        $em         = $this->getDoctrine()->getManager();
        $usuario    = $em->getRepository('JHWEBUsuarioBundle:Usuario')->find($id);

        if (!$usuario) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        return $this->render('JHWEBUsuarioBundle:Usuario:imprimirFormulario.html.twig', array('usuario' => $usuario));
    }

    /**
     * 
     * @Route("/recupera/contrasena", name="usuario_recupera_contrasena")
     */

    public function recuperaContrasena(){
        $peticion = $this->getRequest();
        
        if ($peticion->getMethod() == 'POST') {
            $id = $peticion->get('identificacion');

            $em         = $this->getDoctrine()->getManager();
            $usuario    = $em->getRepository('JHWEBUsuarioBundle:Usuario')->findOneByIdentificacion($id);

            if (!$usuario) {
                $this->get('session')->getFlashBag()->add( 'info','La identificación relacionada no existe.');
                return $this->render('JHWEBUsuarioBundle:Usuario:recuperaContrasena.html.twig');
            }else{
                $password = $this->createPassword();
                $encoder = $this->get('security.encoder_factory')->getEncoder($usuario);
                $usuario->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
                $passwordCodificado = $encoder->encodePassword($password,$usuario->getSalt());
                $usuario->setPassword($passwordCodificado);
                
                $em->flush();

                $message = \Swift_Message::newInstance()
                ->setSubject('Registro ASI')
                ->setFrom($usuario->getCorreo())
                ->setTo($usuario->getCorreo())
                ->setBody(
                    $this->renderView(
                        'JHWEBUsuarioBundle:Usuario:email.html.twig',
                        array(
                            'usuario' => $usuario,
                            'password' => $password
                            )
                    ), 'text/html'
                )
                ->setPriority(2);
                $this->get('mailer')->send($message);

                $this->get('session')->getFlashBag()->add( 'info','A su correo '.$usuario->getCorreo()." se ha enviado una nueva contraseña.");
                return $this->redirect($this->generateUrl('usuario_login'));
            }
        }
        return $this->render('JHWEBUsuarioBundle:Usuario:recuperaContrasena.html.twig');
    }


    /**
     * Lists all Usuario entities.
     *
     * @Route("/", name="usuario")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JHWEBUsuarioBundle:Usuario')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Usuario entity.
     *
     * @Route("/", name="usuario_create")
     * @Method("POST")
     * @Template("JHWEBUsuarioBundle:Usuario:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Usuario();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('usuario_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Usuario entity.
     *
     * @param Usuario $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuario_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Usuario entity.
     *
     * @Route("/new", name="usuario_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Usuario();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Usuario entity.
     *
     * @Route("/{id}", name="usuario_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JHWEBUsuarioBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     * @Route("/{id}/edit", name="usuario_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JHWEBUsuarioBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $departamentos = $em->getRepository('JHWEBDepartamentoBundle:Departamento')->findAll();
        $municipios = $em->getRepository('JHWEBMunicipioBundle:Municipio')->findAll();

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'departamentos' => $departamentos,
            'municipios' => $municipios,
        );
    }

    /**
    * Creates a form to edit a Usuario entity.
    *
    * @param Usuario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuario_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Usuario entity.
     *
     * @Route("/{id}", name="usuario_update")
     * @Method("PUT")
     * @Template("JHWEBUsuarioBundle:Usuario:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JHWEBUsuarioBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setFechaNacimiento(new \DateTime($request->request->get('fechaNacimiento')));
            $entity->setFechaExpedicion(new \DateTime($request->request->get('fechaExpedicion')));

            $em->flush();
            $this->get('session')->getFlashBag()->add( 'info','Actualización realizada');
            return $this->redirect($this->generateUrl('usuario_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Usuario entity.
     *
     * @Route("/{id}", name="usuario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JHWEBUsuarioBundle:Usuario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Usuario entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('usuario'));
    }

    /**
     * Creates a form to delete a Usuario entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usuario_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
