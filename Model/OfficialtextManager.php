<?php

namespace N1c0\OfficialtextBundle\Model;

use N1c0\OfficialtextBundle\Events;
use N1c0\OfficialtextBundle\Event\OfficialtextEvent;
use N1c0\OfficialtextBundle\Event\OfficialtextPersistEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Abstract Officialtext Manager implementation which can be used as base class for your
 * concrete manager.
 */
abstract class OfficialtextManager implements OfficialtextManagerInterface
{
    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * Constructor
     *
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Get a list of Officialtexts.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit, $offset)
    {
        return $this->repository->findBy(array(), null, $limit, $offset);
    }

    /**
     * @param  string          $id
     * @return OfficialtextInterface
     */
    public function findOfficialtextById($id)
    {
        return $this->findOfficialtextBy(array('id' => $id));
    }

    /**
     * Creates an empty element officialtext instance
     *
     * @return Officialtext
     */
    public function createOfficialtext($id = null)
    {
        $class = $this->getClass();
        $officialtext = new $class;

        if (null !== $id) {
            $officialtext->setId($id);
        }

        $event = new OfficialtextEvent($officialtext);
        $this->dispatcher->dispatch(Events::OFFICIALTEXT_CREATE, $event);

        return $officialtext;
    }

    /**
     * Persists a officialtext.
     *
     * @param OfficialtextInterface $officialtext
     */
    public function saveOfficialtext(OfficialtextInterface $officialtext)
    {
        $event = new OfficialtextPersistEvent($officialtext);
        $this->dispatcher->dispatch(Events::OFFICIALTEXT_PRE_PERSIST, $event);

        if ($event->isPersistenceAborted()) {
            return false;
        }

        $this->doSaveOfficialtext($officialtext);

        $event = new OfficialtextEvent($officialtext);
        $this->dispatcher->dispatch(Events::OFFICIALTEXT_POST_PERSIST, $event);

        return true;
    }

    /**
     * Performs the persistence of the Officialtext.
     *
     * @abstract
     * @param OfficialtextInterface $officialtext
     */
    abstract protected function doSaveOfficialtext(OfficialtextInterface $officialtext);
}
