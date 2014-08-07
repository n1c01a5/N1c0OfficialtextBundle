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
     * Returns a flat array of authorsrcs of a specific officialtext.
     *
     * @param  OfficialtextInterface $officialtext
     * @return array           of OfficialtextInterface
     */
    public function findAuthorsrcsByOfficialtext(OfficialtextInterface $officialtext)
    {
        $qb = $this->repository
                ->createQueryBuilder('i')
                ->join('i.officialtext', 'd')
                ->where('d.id = :officialtext')
                ->setParameter('officialtext', $officialtext->getId());

        $authorsrcs = $qb
            ->getQuery()
            ->execute();

        return $authorsrcs;
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
     * Performs persisting of the authorsrc. 
     *
     * @param OfficialtextInterface $officialtext
     */
    protected function doSaveAuthorsrc(AuthorsrcInterface $authorsrc)
    {
        $authorsrc->addOfficialtext($authorsrc->getOfficialtext());
        $authorsrc->getOfficialtext()->setAuthorsrc($authorsrc);
        $this->em->persist($authorsrc->getOfficialtext());
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
