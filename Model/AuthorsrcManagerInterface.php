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
    public function all($limit = 5, $offset = 0);

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
     * Saves a authorsrc
     *
     * @param  AuthorsrcInterface         $authorsrc
     */
    public function saveAuthorsrc(AuthorsrcInterface $authorsrc);
}
