<?php

namespace N1c0\OfficialtextBundle\Model;

Interface AuthorsrcInterface
{
    const STATE_VISIBLE = 0;
    const STATE_DELETED = 1;
    const STATE_SPAM = 2;
    const STATE_PENDING = 3;

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

    /**
     * @return integer The current state of the introduction
     */
    public function getState();
    /**
     * @param integer state
     */
    public function setState($state);
    /**
     * Gets the previous state.
     *
     * @return integer
     */
    public function getPreviousState();
}
