<?php

namespace N1c0\OfficialtextBundle\Model;

/**
 * Interface to be implemented by authorsrc managers. This adds an additional level
 * of abstraction between your application, and the actual repository.
 *
 * All changes to comments should happen through this interface.
 */
interface AuthorsrcManagerInterface
{
    /**
     * Get a list of Authorsrcs.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit, $offset);

    /**
     * @param  string          $id
     * @return AuthorsrcInterface
     */
    public function findAuthorsrcById($id);

    /**
     * Returns an empty authorsrc instance
     *
     * @return Authorsrc
     */
    public function createAuthorsrc(OfficialtextInterface $officialtext);

    /**
     * Checks if the authorsrc was already persisted before, or if it's a new one.
     *
     * @param AuthorsrcInterface $authorsrc
     *
     * @return boolean True, if it's a new authorsrc
     */
    public function isNewAuthorsrc(AuthorsrcInterface $authorsrc);

    /**
     * Saves a authorsrc
     *
     * @param  AuthorsrcInterface         $authorsrc
     */
    public function saveAuthorsrc(AuthorsrcInterface $authorsrc);
}
