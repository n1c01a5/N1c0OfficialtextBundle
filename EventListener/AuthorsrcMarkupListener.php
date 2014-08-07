<?php

namespace N1c0\OfficialtextBundle\EventListener;

use N1c0\OfficialtextBundle\Events;
use N1c0\OfficialtextBundle\Event\AuthorsrcEvent;
use N1c0\OfficialtextBundle\Markup\ParserInterface;
use N1c0\OfficialtextBundle\Model\RawAuthorsrcInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Parses a authorsrc for markup and sets the result
 * into the rawBody property.
 *
 * @author Wagner Nicolas <contact@wagner-nicolas.com>
 */
class AuthorsrcMarkupListener implements EventSubscriberInterface
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
     * Parses raw authorsrc data and assigns it to the rawBody
     * property.
     *
     * @param \N1c0\OfficialtextBundle\Event\AuthorsrcEvent $event
     */
    public function markup(AuthorsrcEvent $event)
    {
        $authorsrc = $event->getAuthorsrc();

        if (!$authorsrc instanceof RawAuthorsrcInterface) {
            return;
        }

        $result = $this->parser->parse($authorsrc->getBody());
        $authorsrc->setRawBody($result);
    }

    public static function getSubscribedEvents()
    {
        return array(Events::AUTHORSRC_PRE_PERSIST => 'markup');
    }
}
