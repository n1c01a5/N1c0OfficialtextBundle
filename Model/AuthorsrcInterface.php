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
     * Set firstname
     *
     * @param string $firstname
     * @return AuthorsrcInterface
     */
    public function setFirstName($firstname);

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstName();
    /**
     * @return OfficialtextInterface
     */
    public function getOfficialtext();

    /**
     * @param OfficialtextInterface $officialtext
     */
    public function setOfficialtext(OfficialtextInterface $officialtext);
}