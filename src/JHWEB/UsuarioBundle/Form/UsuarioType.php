<?php

namespace JHWEB\UsuarioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('identificacion')
            ->add('nombres')
            ->add('apellidos')
            ->add('genero','choice',array(
                'choices'   => array('F' => 'Femenino', 'M' => 'Masculino', 'Otro' => 'Otro'),
                'empty_value' => false
            ))
            ->add('fijo')
            ->add('celular')
            ->add('direccion')
            ->add('ubicacion')
            ->add('fotografia','file',array('required'=>false))
            ->add('correo')
            ->add('titulo')
            ->add('acepta','checkbox')
            ->add('escolaridad','entity', array(
            'class' => 'JHWEBEscolaridadBundle:Escolaridad',
            'property' => 'nombre',
            'empty_value' => 'Elija Escolaridad'
            ))
            ->add('ocupacion','entity', array(
            'class' => 'JHWEBOcupacionBundle:Ocupacion',
            'property' => 'nombre',
            'empty_value' => 'Elija Ocupación'
            ))
            ->add('etnia','entity', array(
            'class' => 'JHWEBEtniaBundle:Etnia',
            'property' => 'nombre',
            'empty_value' => 'Elija Entia'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\UsuarioBundle\Entity\Usuario'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jhweb_usuariobundle_usuario';
    }
}
