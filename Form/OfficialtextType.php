<?php

namespace N1c0\OfficialtextBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OfficialtextType extends AbstractType
{
    private $officialtextClass;

    public function __construct($officialtextClass)
    {
        $this->officialtextClass = $officialtextClass;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('authorsrc', 'entity', array(
                'class' => 'BundleOfficialtextBundle:Authorsrcoff',
                'property' => 'Name'
            ))
            ->add('title')
            ->add('body')
            ->add('url')
            ->add('createdAt')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            'data_class' => $this->officialtextClass,
            'csrf_protection' => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'n1c0_officialtext_officialtext';
    }
}
