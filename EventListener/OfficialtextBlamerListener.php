<?php

namespace N1c0\OfficialtextBundle\EventListener;

use N1c0\OfficialtextBundle\Events;
use N1c0\OfficialtextBundle\Event\OfficialtextEvent;
use N1c0\OfficialtextBundle\Model\SignedOfficialtextInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Blames a officialtext using Symfony2 security component
 */
class OfficialtextBlamerListener implements EventSubscriberInterface
{
    /**
     * @var SecurityContext
     */
    protected $securityContext;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Constructor.
     *
     * @param SecurityContextInterface $securityContext
     * @param LoggerInterface          $logger
     */
    public function __construct(SecurityContextInterface $securityContext = null, LoggerInterface $logger = null)
    {
        $this->securityContext = $securityContext;
        $this->logger = $logger;
    }

    /**
     * Assigns the currently logged in user to a Officialtext.
     *
     * @param  \N1c0\OfficialtextBundle\Event\OfficialtextEvent $event
     * @return void
     */
    public function blame(OfficialtextEvent $event)
    {
        $officialtext = $event->getOfficialtext();

        if (null === $this->securityContext) {
            if ($this->logger) {
                $this->logger->debug("Officialtext Blamer did not receive the security.context service.");
            }

            return;
        }

        if (!$officialtext instanceof SignedOfficialtextInterface) {
            if ($this->logger) {
                $this->logger->debug("Officialtext does not implement SignedOfficialtextInterface, skipping");
            }

            return;
        }

        if (null === $this->securityContext->getToken()) {
            if ($this->logger) {
                $this->logger->debug("There is no firewall configured. We cant get a user.");
            }

            return;
        }

        if ($this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->securityContext->getToken()->getUser();
            $officialtext->setAuthor($user);
            if (!$officialtext->getAuthors()->contains($user)) {
                $officialtext->addAuthor($user);
            }

        }
    }

    public static function getSubscribedEvents()
    {
        return array(Events::QUOTE_PRE_PERSIST => 'blame');
    }
}
