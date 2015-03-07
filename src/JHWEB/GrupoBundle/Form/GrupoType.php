<?php

namespace JHWEB\GrupoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GrupoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('detalle')
            ->add('fecha')
            ->add('usuarios')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\GrupoBundle\Entity\Grupo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jhweb_grupobundle_grupo';
    }
}
