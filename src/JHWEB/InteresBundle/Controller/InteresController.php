<?php

namespace JHWEB\InteresBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JHWEB\InteresBundle\Entity\Interes;
use JHWEB\InteresBundle\Form\InteresType;

/**
 * Interes controller.
 *
 * @Route("/interes")
 */
class InteresController extends Controller
{

    /**
     * Lists all Interes entities.
     *
     * @Route("/", name="interes")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JHWEBInteresBundle:Interes')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Interes entity.
     *
     * @Route("/", name="interes_create")
     * @Method("POST")
     * @Template("JHWEBInteresBundle:Interes:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Interes();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('interes_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Interes entity.
     *
     * @param Interes $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Interes $entity)
    {
        $form = $this->createForm(new InteresType(), $entity, array(
            'action' => $this->generateUrl('interes_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Interes entity.
     *
     * @Route("/new", name="interes_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Interes();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Interes entity.
     *
     * @Route("/{id}", name="interes_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JHWEBInteresBundle:Interes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Interes entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Interes entity.
     *
     * @Route("/{id}/edit", name="interes_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JHWEBInteresBundle:Interes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Interes entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Interes entity.
    *
    * @param Interes $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Interes $entity)
    {
        $form = $this->createForm(new InteresType(), $entity, array(
            'action' => $this->generateUrl('interes_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Interes entity.
     *
     * @Route("/{id}", name="interes_update")
     * @Method("PUT")
     * @Template("JHWEBInteresBundle:Interes:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JHWEBInteresBundle:Interes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Interes entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('interes_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Interes entity.
     *
     * @Route("/{id}", name="interes_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JHWEBInteresBundle:Interes')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Interes entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('interes'));
    }

    /**
     * Creates a form to delete a Interes entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('interes_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
