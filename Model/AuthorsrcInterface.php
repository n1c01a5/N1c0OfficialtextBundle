<?php

namespace N1c0\OfficialtextBundle\Model;

Interface AuthorsrcInterface
{
    /**
     * @return mixed unique ID for this authorsrc
     */
    public function getId();
    
    /**
     * Set name
     *
     * @param string $name
     * @return AuthorsrcInterface
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * @return OfficialtextInterface
     */
    public function getOfficialtext();

    /**
     * @param OfficialtextInterface $officialtext
     */
    public function setOfficialtext(OfficialtextInterface $officialtext);
}
