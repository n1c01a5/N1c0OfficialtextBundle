<?php

namespace N1c0\OfficialtextBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * A signed officialtext is bound to a FOS\UserBundle User model.
 */
interface SignedOfficialtextInterface extends OfficialtextInterface
{
    /**
     * Add user 
     *
     * @param Application\UserBundle\Entity\User $user
     */
    public function addAuthor(\Application\UserBundle\Entity\User $user);

    /**
     * Remove user
     *
     * @param Application\UserBundle\Entity\User $user
     */
    public function removeUser(\Application\UserBundle\Entity\User $user);

    /**
     * Gets the authors of the Officialtext
     *
     * @return UserInterface
     */
    public function getAuthors();

    /**
     * Gets the last author of the Officialtext
     *
     * @return UserInterface
     */
    public function getAuthor();
}

