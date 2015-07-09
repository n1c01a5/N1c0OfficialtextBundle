<?php

namespace N1c0\OfficialtextBundle\Entity;

use Doctrine\ORM\EntityManager;
use N1c0\OfficialtextBundle\Model\AuthorsrcManager as BaseAuthorsrcManager;
use N1c0\OfficialtextBundle\Model\OfficialtextInterface;
use N1c0\OfficialtextBundle\Model\AuthorsrcInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Default ORM AuthorsrcManager.
 *
 */
class AuthorsrcManager extends BaseAuthorsrcManager
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $class;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher
     * @param \Doctrine\ORM\EntityManager                                 $em
     * @param string                                                      $class
     */
    public function __construct(EventDispatcherInterface $dispatcher, EntityManager $em, $class)
    {
        parent::__construct($dispatcher);

        $this->em = $em;
        $this->repository = $em->getRepository($class);

        $metadata = $em->getClassMetadata($class);
        $this->class = $metadata->name;
    }

    /**
     * Find one authorsrc by its ID
     *
     * @param  array           $criteria
     * @return AuthorsrcInterface
     */
    public function findOfficialtextById($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Finds all Authorsrcs.
     *
     * @return array of AuthorsrcInterface
     */
    public function findAllAuthorsrcs()
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritDoc}
     */
    public function isNewAuthorsrc(AuthorsrcInterface $authorsrc)
    {
        return !$this->em->getUnitOfWork()->isInIdentityMap($authorsrc);
    }

    /**
     * Performs persisting of the authorsrc.
     *
     * @param OfficialtextInterface $officialtext
     */
    protected function doSaveAuthorsrc(AuthorsrcInterface $authorsrc)
    {
        $this->em->persist($authorsrc);
        $this->em->flush();
    }

    /**
     * Returns the fully qualified authorsrc officialtext class name
     *
     * @return string
     **/
    public function getClass()
    {
        return $this->class;
    }
}
