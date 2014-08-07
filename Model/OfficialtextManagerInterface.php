<?php

namespace N1c0\OfficialtextBundle\Model;

/**
 * Interface to be implemented by element officialtext managers. This adds an additional level
 * of abstraction between your application, and the actual repository.
 *
 * All changes to element officialtext should happen through this interface.
 */
interface OfficialtextManagerInterface
{
    /**
     * Get a list of Officialtexts.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0);

    /**
     * @param  string          $id
     * @return OfficialtextInterface
     */
    public function findOfficialtextById($id);

    /**
     * Finds one element officialtext by the given criteria
     *
     * @param  array           $criteria
     * @return OfficialtextInterface
     */
    public function findOfficialtextBy(array $criteria);

    /**
     * Finds officialtexts by the given criteria
     *
     * @param array $criteria
     *
     * @return array of OfficialtextInterface
     */
    public function findOfficialtextsBy(array $criteria);

    /**
     * Finds all officialtexts.
     *
     * @return array of OfficialtextInterface
     */
    public function findAllOfficialtexts();

    /**
     * Creates an empty element officialtext instance
     *
     * @param  bool   $id
     * @return Officialtext
     */
    public function createOfficialtext($id = null);

    /**
     * Saves a officialtext
     *
     * @param OfficialtextInterface $officialtext
     */
    public function saveOfficialtext(OfficialtextInterface $officialtext);

    /**
     * Checks if the officialtext was already persisted before, or if it's a new one.
     *
     * @param OfficialtextInterface $officialtext
     *
     * @return boolean True, if it's a new officialtext
     */
    public function isNewOfficialtext(OfficialtextInterface $officialtext);

    /**
     * Returns the element officialtext fully qualified class name
     *
     * @return string
     */
    public function getClass();
}
