<?php

namespace N1c0\OfficialtextBundle\EventListener;

use N1c0\OfficialtextBundle\Events;
use N1c0\OfficialtextBundle\Event\OfficialtextEvent;
use N1c0\OfficialtextBundle\Markup\ParserInterface;
use N1c0\OfficialtextBundle\Model\RawOfficialtextInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Parses a officialtext for markup and sets the result
 * into the rawBody property.
 *
 * @author Wagner Nicolas <contact@wagner-nicolas.com>
 */
class OfficialtextMarkupListener implements EventSubscriberInterface
{
    /**
     * @var ParserInterface
     */
    protected $parser;

    /**
     * Constructor.
     *
     * @param \N1c0\OfficialtextBundle\Markup\ParserInterface $parser
     */
    public function __construct(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Parses raw officialtext data and assigns it to the rawBody
     * property.
     *
     * @param \N1c0\OfficialtextBundle\Event\OfficialtextEvent $event
     */
    public function markup(OfficialtextEvent $event)
    {
        $officialtext = $event->getOfficialtext();

        if (!$officialtext instanceof RawOfficialtextInterface) {
            return;
        }

        $result = $this->parser->parse($officialtext->getBody());
        $officialtext->setRawBody($result);
    }

    public static function getSubscribedEvents()
    {
        return array(Events::QUOTE_PRE_PERSIST => 'markup');
    }
}
