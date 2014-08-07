<?php

namespace N1c0\OfficialtextBundle\Entity;

use Doctrine\ORM\EntityManager;
use N1c0\OfficialtextBundle\Model\OfficialtextManager as BaseOfficialtextManager;
use N1c0\OfficialtextBundle\Model\OfficialtextInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Default ORM OfficialtextManager.
 *
 */
class OfficialtextManager extends BaseOfficialtextManager
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
     * Finds one element officialtext by the given criteria
     *
     * @param  array           $criteria
     * @return OfficialtextInterface
     */
    public function findOfficialtextBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function findOfficialtextsBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }

    /**
     * Finds all officialtexts.
     *
     * @return array of OfficialtextInterface
     */
    public function findAllOfficialtexts()
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritDoc}
     */
    public function isNewOfficialtext(OfficialtextInterface $officialtext)
    {
        return !$this->em->getUnitOfWork()->isInIdentityMap($officialtext);
    }

    /**
     * Saves a officialtext
     *
     * @param OfficialtextInterface $officialtext
     */
    protected function doSaveOfficialtext(OfficialtextInterface $officialtext)
    {
        $this->em->persist($officialtext);
        $this->em->flush();
    }

    /**
     * Returns the fully qualified element officialtext class name
     *
     * @return string
     **/
    public function getClass()
    {
        return $this->class;
    }
}
