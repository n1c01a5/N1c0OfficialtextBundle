<?php

namespace N1c0\OfficialtextBundle\Event;

use N1c0\OfficialtextBundle\Model\OfficialtextInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * An event that occurs related to a officialtext.
 */
class OfficialtextEvent extends Event
{
    private $officialtext;

    /**
     * Constructs an event.
     *
     * @param \N1c0\OfficialtextBundle\Model\OfficialtextInterface $officialtext
     */
    public function __construct(OfficialtextInterface $officialtext)
    {
        $this->officialtext = $officialtext;
    }

    /**
     * Returns the officialtext for this event.
     *
     * @return \N1c0\OfficialtextBundle\Model\OfficialtextInterface
     */
    public function getOfficialtext()
    {
        return $this->officialtext;
    }
}
