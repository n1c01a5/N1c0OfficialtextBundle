<?php

namespace N1c0\OfficialtextBundle\FormFactory;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * OfficialtextForm factory class.
 */
class OfficialtextFormFactory implements OfficialtextFormFactoryInterface
{
    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $name;

    /**
     * Constructor.
     *
     * @param FormFactoryInterface $formFactory
     * @param string               $type
     * @param string               $name
     */
    public function __construct(FormFactoryInterface $formFactory, $type, $name)
    {
        $this->formFactory = $formFactory;
        $this->type        = $type;
        $this->name        = $name;
    }

    /**
     * Creates a new form.
     *
     * @return FormInterface
     */
    public function createForm()
    {
        $builder = $this->formFactory->createNamedBuilder($this->name, $this->type);

        return $builder->getForm();
    }
}
