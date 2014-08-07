<?php

namespace N1c0\OfficialtextBundle\Model;

/**
 * Storage agnostic authorsrc officialtext object
 */
abstract class Authorsrc implements AuthorsrcInterface
{
    /**
     * Authorsrc id 
     *
     * @var mixed
     */
    protected $id;

    /**
     * Name
     *
     * @var string
     */
    protected $name;

    /**
     * Firstname
     *
     * @var string
     */
    protected $firstname;

    /**
     * Birthday
     *
     * @var datetime
     */
    protected $birthday;

   /**
     * Website
     *
     * @var string
     */
    protected $website;

   /**
     * Bio
     *
     * @var text
     */
    protected $bio;

    /**
     * Should be mapped by the end developer.
     *
     * @var OfficialtextInterface
     */
    protected $officialtext;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param  string
     * @return null
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstname;
    }

    /**
     * @param  string
     * @return null
     */
    public function setFirstName($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param  string
     * @return null
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param  string
     * @return null
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return text
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * @param  text
     * @return null
     */
    public function setBio($bio)
    {
        $this->bio = $bio;
    }

    /**
     * @return OfficialtextInterface
     */
    public function getOfficialtext()
    {
        return $this->officialtext;
    }

    /**
     * @param OfficialtextInterface $officialtext
     *
     * @return void
     */
    public function setOfficialtext(OfficialtextInterface $officialtext)
    {
        $this->officialtext = $officialtext;
    }

    /**
     * @return array with the names of the authorsrc authors
     */
    public function getAuthorsName()
    {
        return 'Anonymous';
    }

    /**
     * @return array with the name of the authorsrc author
     */
    public function getAuthorName()
    {
        return 'Anonymous';
    }

    public function __toString()
    {
        return 'Authorsrc #'.$this->getId();
    }
}
