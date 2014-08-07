<?php

namespace N1c0\OfficialtextBundle\FormFactory;

use Symfony\Component\Form\FormInterface;

/**
 * Officialtext form creator
 */
interface OfficialtextFormFactoryInterface
{
    /**
     * Creates a officialtext form
     *
     * @return FormInterface
     */
    public function createForm();
}
