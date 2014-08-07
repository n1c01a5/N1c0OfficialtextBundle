<?php

namespace N1c0\OfficialtextBundle;

final class Events
{
    /**
     * The PRE_PERSIST event occurs prior to the persistence backend
     * persisting the Officialtext.
     *
     * This event allows you to modify the data in the Officialtext prior
     * to persisting occuring. The listener receives a
     * N1c0\OfficialtextBundle\Event\OfficialtextPersistEvent instance.
     *
     * Persisting of the officialtext can be aborted by calling
     * $event->abortPersist()
     *
     * @var string
     */
    const QUOTE_PRE_PERSIST = 'n1c0_officialtext.officialtext.pre_persist';

    /**
     * The POST_PERSIST event occurs after the persistence backend
     * persisted the Officialtext.
     *
     * This event allows you to notify users or perform other actions
     * that might require the Officialtext to be persisted before performing
     * those actions. The listener receives a
     * N1c0\OfficialtextBundle\Event\OfficialtextEvent instance.
     *
     * @var string
     */
    const QUOTE_POST_PERSIST = 'n1c0_officialtext.officialtext.post_persist';

    /**
     * The CREATE event occurs when the manager is asked to create
     * a new instance of a Officialtext.
     *
     * The listener receives a N1c0\OfficialtextBundle\Event\OfficialtextEvent
     * instance.
     *
     * @var string
     */
    const QUOTE_CREATE = 'n1c0_officialtext.officialtext.create';

    /**
     * The PRE_PERSIST event occurs prior to the persistence backend
     * persisting the Authorsrc.
     *
     * This event allows you to modify the data in the Authorsrc prior
     * to persisting occuring. The listener receives a
     * N1c0\OfficialtextBundle\Event\AuthorsrcPersistEvent instance.
     *
     * Persisting of the officialtext can be aborted by calling
     * $event->abortPersist()
     *
     * @var string
     */
    const AUTHORSRC_PRE_PERSIST = 'n1c0_officialtext.authorsrc.pre_persist';

    /**
     * The POST_PERSIST event occurs after the persistence backend
     * persisted the Authorsrc.
     *
     * This event allows you to notify users or perform other actions
     * that might require the Authorsrc to be persisted before performing
     * those actions. The listener receives a
     * N1c0\OfficialtextBundle\Event\AuthorsrcEvent instance.
     *
     * @var string
     */
    const AUTHORSRC_POST_PERSIST = 'n1c0_officialtext.authorsrc.post_persist';

    /**
     * The CREATE event occurs when the manager is asked to create
     * a new instance of a Authorsrc.
     *
     * The listener receives a N1c0\OfficialtextBundle\Event\AuthorsrcEvent
     * instance.
     *
     * @var string
     */
    const AUTHORSRC_CREATE = 'n1c0_officialtext.authorsrc.create';

    /**
     * The PRE_PERSIST event occurs prior to the persistence backend
     * persisting the Housepublishing.
     *
     * This event allows you to modify the data in the Authorsrc prior
     * to persisting occuring. The listener receives a
     * N1c0\OfficialtextBundle\Event\HousepublishingPersistEvent instance.
     *
     * Persisting of the officialtext can be aborted by calling
     * $event->abortPersist()
     *
     * @var string
     */
    const HOUSEPUBLISHING_PRE_PERSIST = 'n1c0_officialtext.housepublishing.pre_persist';

    /**
     * The POST_PERSIST event occurs after the persistence backend
     * persisted the Housepublishing.
     *
     * This event allows you to notify users or perform other actions
     * that might require the Housepublishing to be persisted before performing
     * those actions. The listener receives a
     * N1c0\OfficialtextBundle\Event\HousepublishingEvent instance.
     *
     * @var string
     */
    const HOUSEPUBLISHING_POST_PERSIST = 'n1c0_officialtext.housepublishing.post_persist';

    /**
     * The CREATE event occurs when the manager is asked to create
     * a new instance of a Housepublishing.
     *
     * The listener receives a N1c0\OfficialtextBundle\Event\HousepublishingEvent
     * instance.
     *
     * @var string
     */
    const HOUSEPUBLISHING_CREATE = 'n1c0_officialtext.housepublishing.create';

    /**
     * The PRE_PERSIST event occurs prior to the persistence backend
     * persisting the Tag.
     *
     * This event allows you to modify the data in the Authorsrc prior
     * to persisting occuring. The listener receives a
     * N1c0\OfficialtextBundle\Event\TagPersistEvent instance.
     *
     * Persisting of the officialtext can be aborted by calling
     * $event->abortPersist()
     *
     * @var string
     */
    const TAG_PRE_PERSIST = 'n1c0_officialtext.tag.pre_persist';

    /**
     * The POST_PERSIST event occurs after the persistence backend
     * persisted the Tag.
     *
     * This event allows you to notify users or perform other actions
     * that might require the Tag to be persisted before performing
     * those actions. The listener receives a
     * N1c0\OfficialtextBundle\Event\TagEvent instance.
     *
     * @var string
     */
    const TAG_POST_PERSIST = 'n1c0_officialtext.tag.post_persist';

    /**
     * The CREATE event occurs when the manager is asked to create
     * a new instance of a Tag.
     *
     * The listener receives a N1c0\OfficialtextBundle\Event\TagEvent
     * instance.
     *
     * @var string
     */
    const TAG_CREATE = 'n1c0_officialtext.tag.create';

    /**
     * The PRE_PERSIST event occurs prior to the persistence backend
     * persisting the Book.
     *
     * This event allows you to modify the data in the Book prior
     * to persisting occuring. The listener receives a
     * N1c0\OfficialtextBundle\Event\BookPersistEvent instance.
     *
     * Persisting of the officialtext can be aborted by calling
     * $event->abortPersist()
     *
     * @var string
     */
    const BOOK_PRE_PERSIST = 'n1c0_officialtext.book.pre_persist';

    /**
     * The POST_PERSIST event occurs after the persistence backend
     * persisted the Officialtext.
     *
     * This event allows you to notify users or perform other actions
     * that might require the Officialtext to be persisted before performing
     * those actions. The listener receives a
     * N1c0\OfficialtextBundle\Event\BookEvent instance.
     *
     * @var string
     */
    const BOOK_POST_PERSIST = 'n1c0_officialtext.book.post_persist';

    /**
     * The CREATE event occurs when the manager is asked to create
     * a new instance of a Book.
     *
     * The listener receives a N1c0\OfficialtextBundle\Event\BookEvent
     * instance.
     *
     * @var string
     */
    const BOOK_CREATE = 'n1c0_officialtext.book.create';
}
