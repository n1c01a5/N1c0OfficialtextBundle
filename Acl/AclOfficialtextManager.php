<?php

namespace N1c0\OfficialtextBundle\Acl;

use N1c0\OfficialtextBundle\Model\OfficialtextInterface;
use N1c0\OfficialtextBundle\Model\OfficialtextManagerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Wraps a real implementation of OfficialtextManagerInterface and
 * performs Acl checks with the configured Officialtext Acl service.
 */
class AclOfficialtextManager implements OfficialtextManagerInterface
{
    /**
     * The OfficialtextManager instance to be wrapped with ACL.
     *
     * @var OfficialtextManagerInterface
     */
    protected $realManager;

    /**
     * The OfficialtextAcl instance for checking permissions.
     *
     * @var OfficialtextAclInterface
     */
    protected $officialtextAcl;

    /**
     * Constructor.
     *
     * @param OfficialtextManagerInterface $officialtextManager The concrete OfficialtextManager service
     * @param OfficialtextAclInterface     $officialtextAcl     The Officialtext Acl service
     */
    public function __construct(OfficialtextManagerInterface $officialtextManager, OfficialtextAclInterface $officialtextAcl)
    {
        $this->realManager = $officialtextManager;
        $this->officialtextAcl  = $officialtextAcl;
    }

    /**
     * {@inheritDoc}
     */
    public function all($limit = 5, $offset = 0)
    {
        $officialtexts = $this->realManager->all();

        if (!$this->authorizeViewOfficialtext($officialtexts)) {
            throw new AccessDeniedException();
        }

        return $officialtexts;
    }

    /**
     * {@inheritDoc}
     */
    public function findOfficialtextBy(array $criteria){
    }

    /**
     * {@inheritDoc}
     */
    public function findOfficialtextsBy(array $criteria){
    }

    /**
     * {@inheritDoc}
     */
    public function findAllOfficialtexts(){
    }                 


    /**
     * {@inheritDoc}
     */
    public function saveOfficialtext(OfficialtextInterface $officialtext)
    {
        if (!$this->officialtextAcl->canCreate()) {
            throw new AccessDeniedException();
        }

        $newOfficialtext = $this->isNewOfficialtext($officialtext);

        if (!$newOfficialtext && !$this->officialtextAcl->canEdit($officialtext)) {
            throw new AccessDeniedException();
        }

        if (($officialtext::STATE_DELETED === $officialtext->getState() || $officialtext::STATE_DELETED === $officialtext->getPreviousState())
            && !$this->officialtextAcl->canDelete($officialtext)
        ) {
            throw new AccessDeniedException();
        }

        $this->realManager->saveOfficialtext($officialtext);

        if ($newOfficialtext) {
            $this->officialtextAcl->setDefaultAcl($officialtext);
        }
    }

    /**
     * {@inheritDoc}
     **/
    public function findOfficialtextById($id)
    {
        $officialtext = $this->realManager->findOfficialtextById($id);

        if (null !== $officialtext && !$this->officialtextAcl->canView($officialtext)) {
            throw new AccessDeniedException();
        }

        return $officialtext;
    }

    /**
     * {@inheritDoc}
     */
    public function createOfficialtext($id = null)
    {
        return $this->realManager->createOfficialtext($id);
    }

    /**
     * {@inheritDoc}
     */
    public function isNewOfficialtext(OfficialtextInterface $officialtext)
    {
        return $this->realManager->isNewOfficialtext($officialtext);
    }

    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->realManager->getClass();
    }

    /**
     * Check if the officialtext have appropriate view permissions.
     *
     * @param  array   $officialtexts A comment tree
     * @return boolean
     */
    protected function authorizeViewOfficialtext(array $officialtexts)
    {
        foreach ($officialtexts as $officialtext) {
            if (!$this->officialtextAcl->canView($officialtext)) {
                return false;
            }
        }

        return true;
    }
}
