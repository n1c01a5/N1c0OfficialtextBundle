<?php

namespace N1c0\OfficialtextBundle\Acl;

use N1c0\OfficialtextBundle\Model\OfficialtextInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Implements Role checking using the Symfony2 Security component
 */
class RoleOfficialtextAcl implements OfficialtextAclInterface
{
    /**
     * The current Security Context.
     *
     * @var SecurityContextInterface
     */
    private $securityContext;

    /**
     * The FQCN of the Officialtext object.
     *
     * @var string
     */
    private $officialtextClass;

    /**
     * The role that will grant create permission for a officialtext.
     *
     * @var string
     */
    private $createRole;

    /**
     * The role that will grant view permission for a officialtext.
     *
     * @var string
     */
    private $viewRole;

    /**
     * The role that will grant edit permission for a officialtext.
     *
     * @var string
     */
    private $editRole;

    /**
     * The role that will grant delete permission for a officialtext.
     *
     * @var string
     */
    private $deleteRole;

    /**
     * Constructor.
     *
     * @param SecurityContextInterface $securityContext
     * @param string                   $createRole
     * @param string                   $viewRole
     * @param string                   $editRole
     * @param string                   $deleteRole
     * @param string                   $officialtextClass
     */
    public function __construct(SecurityContextInterface $securityContext,
                                $createRole,
                                $viewRole,
                                $editRole,
                                $deleteRole,
                                $officialtextClass
    )
    {
        $this->securityContext   = $securityContext;
        $this->createRole        = $createRole;
        $this->viewRole          = $viewRole;
        $this->editRole          = $editRole;
        $this->deleteRole        = $deleteRole;
        $this->officialtextClass      = $officialtextClass;
    }

    /**
     * Checks if the Security token has an appropriate role to create a new Officialtext.
     *
     * @return boolean
     */
    public function canCreate()
    {
        return $this->securityContext->isGranted($this->createRole);
    }

    /**
     * Checks if the Security token is allowed to view the specified Officialtext.
     *
     * @param  OfficialtextInterface $officialtext
     * @return boolean
     */
    public function canView(OfficialtextInterface $officialtext)
    {
        return $this->securityContext->isGranted($this->viewRole);
    }

    /**
     * Checks if the Security token is allowed to reply to a parent officialtext.
     *
     * @param  OfficialtextInterface|null $parent
     * @return boolean
     */
    public function canReply(OfficialtextInterface $parent = null)
    {
        if (null !== $parent) {
            return $this->canCreate() && $this->canView($parent);
        }

        return $this->canCreate();
    }

    /**
     * Checks if the Security token has an appropriate role to edit the supplied Officialtext.
     *
     * @param  OfficialtextInterface $officialtext
     * @return boolean
     */
    public function canEdit(OfficialtextInterface $officialtext)
    {
        return $this->securityContext->isGranted($this->editRole);
    }

    /**
     * Checks if the Security token is allowed to delete a specific Officialtext.
     *
     * @param  OfficialtextInterface $officialtext
     * @return boolean
     */
    public function canDelete(OfficialtextInterface $officialtext)
    {
        return $this->securityContext->isGranted($this->deleteRole);
    }

    /**
     * Role based Acl does not require setup.
     *
     * @param  OfficialtextInterface $officialtext
     * @return void
     */
    public function setDefaultAcl(OfficialtextInterface $officialtext)
    {

    }

    /**
     * Role based Acl does not require setup.
     *
     * @return void
     */
    public function installFallbackAcl()
    {

    }

    /**
     * Role based Acl does not require setup.
     *
     * @return void
     */
    public function uninstallFallbackAcl()
    {

    }
}
