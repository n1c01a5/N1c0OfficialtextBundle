<?php

namespace N1c0\OfficialtextBundle\Model;

use DateTime;

/**
 * Storage agnostic element officialtext object
 */
abstract class Officialtext implements OfficialtextInterface
{
    /**
     * Id, a unique string that binds the elements together in a officialtext (tree).
     * It can be a url or really anything unique.
     *
     * @var mixed
     */
    protected $id;

    /**
     * Title
     *
     * @var string
     */
    protected $title;

    /**
     * Body
     *
     * @var string
     */
    protected $body;

    /**
     * Url
     *
     * @var string
     */
    protected $url;

    /**
     * CreatedAt
     *
     * @var datetime
     */
    protected $createdAt;

    /**
     * Current state of the officialtext.
     *
     * @var integer
     */
    protected $state = 0;

    /**
     * The previous state of the officialtext.
     *
     * @var integer
     */
    protected $previousState = 0;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param  string
     * @return null
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param  string
     * @return null
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param  string
     * @return null
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return date
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param  date
     * @return null
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
    /**
     * @return array with the names of the officialtext authors
     */
    public function getAuthorsName()
    {
        return 'Anonymous';
    }

    /**
     * @return array with the name of the officialtext author
     */
    public function getAuthorName()
    {
        return 'Anonymous';
    }

    /**
     * {@inheritDoc}
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * {@inheritDoc}
     */
    public function setState($state)
    {
        $this->previousState = $this->state;
        $this->state = $state;
    }

    /**
     * {@inheritDoc}
     */
    public function getPreviousState()
    {
        return $this->previousState;
    }

    public function __toString()
    {
        return 'Officialtext #'.$this->getId();
    }
}
