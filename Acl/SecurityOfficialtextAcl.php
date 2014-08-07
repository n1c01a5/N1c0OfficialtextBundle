<?php

namespace N1c0\OfficialtextBundle\Acl;

use N1c0\OfficialtextBundle\Model\OfficialtextInterface;
use N1c0\OfficialtextBundle\Model\SignedOfficialtextInterface;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\RoleSecurityIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Exception\AclAlreadyExistsException;
use Symfony\Component\Security\Acl\Model\AclInterface;
use Symfony\Component\Security\Acl\Model\MutableAclProviderInterface;
use Symfony\Component\Security\Acl\Model\ObjectIdentityRetrievalStrategyInterface;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Implements ACL checking using the Symfony2 Security component
 */
class SecurityOfficialtextAcl implements OfficialtextAclInterface
{
    /**
     * Used to retrieve ObjectIdentity instances for objects.
     *
     * @var ObjectIdentityRetrievalStrategyInterface
     */
    protected $objectRetrieval;

    /**
     * The AclProvider.
     *
     * @var MutableAclProviderInterface
     */
    protected $aclProvider;

    /**
     * The current Security Context.
     *
     * @var SecurityContextInterface
     */
    protected $securityContext;

    /**
     * The FQCN of the Officialtext object.
     *
     * @var string
     */
    protected $officialtextClass;

    /**
     * The Class OID for the Officialtext object.
     *
     * @var ObjectIdentity
     */
    protected $oid;

    /**
     * Constructor.
     *
     * @param SecurityContextInterface                 $securityContext
     * @param ObjectIdentityRetrievalStrategyInterface $objectRetrieval
     * @param MutableAclProviderInterface              $aclProvider
     * @param string                                   $officialtextClass
     */
    public function __construct(SecurityContextInterface $securityContext,
                                ObjectIdentityRetrievalStrategyInterface $objectRetrieval,
                                MutableAclProviderInterface $aclProvider,
                                $officialtextClass
    )
    {
        $this->objectRetrieval   = $objectRetrieval;
        $this->aclProvider       = $aclProvider;
        $this->securityContext   = $securityContext;
        $this->officialtextClass      = $officialtextClass;
        $this->oid               = new ObjectIdentity('class', $this->officialtextClass);
    }

    /**
     * Checks if the Security token is allowed to create a new Officialtext.
     *
     * @return boolean
     */
    public function canCreate()
    {
        return $this->securityContext->isGranted('CREATE', $this->oid);
    }

    /**
     * Checks if the Security token is allowed to view the specified Officialtext.
     *
     * @param  OfficialtextInterface $officialtext
     * @return boolean
     */
    public function canView(OfficialtextInterface $officialtext)
    {
        return $this->securityContext->isGranted('VIEW', $officialtext);
    }


    /**
     * Checks if the Security token is allowed to edit the specified Officialtext.
     *
     * @param  OfficialtextInterface $officialtext
     * @return boolean
     */
    public function canEdit(OfficialtextInterface $officialtext)
    {
        return $this->securityContext->isGranted('EDIT', $officialtext);
    }

    /**
     * Checks if the Security token is allowed to delete the specified Officialtext.
     *
     * @param  OfficialtextInterface $officialtext
     * @return boolean
     */
    public function canDelete(OfficialtextInterface $officialtext)
    {
        return $this->securityContext->isGranted('DELETE', $officialtext);
    }

    /**
     * Sets the default object Acl entry for the supplied Officialtext.
     *
     * @param  OfficialtextInterface $officialtext
     * @return void
     */
    public function setDefaultAcl(OfficialtextInterface $officialtext)
    {
        $objectIdentity = $this->objectRetrieval->getObjectIdentity($officialtext);
        $acl = $this->aclProvider->createAcl($objectIdentity);

        if ($officialtext instanceof SignedOfficialtextInterface &&
            null !== $officialtext->getAuthor()) {
            $securityIdentity = UserSecurityIdentity::fromAccount($officialtext->getAuthor());
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
        }

        $this->aclProvider->updateAcl($acl);
    }

    /**
     * Installs default Acl entries for the Officialtext class.
     *
     * This needs to be re-run whenever the Officialtext class changes or is subclassed.
     *
     * @return void
     */
    public function installFallbackAcl()
    {
        $oid = new ObjectIdentity('class', $this->officialtextClass);

        try {
            $acl = $this->aclProvider->createAcl($oid);
        } catch (AclAlreadyExistsException $exists) {
            return;
        }

        $this->doInstallFallbackAcl($acl, new MaskBuilder());
        $this->aclProvider->updateAcl($acl);
    }

    /**
     * Installs the default Class Ace entries into the provided $acl object.
     *
     * Override this method in a subclass to change what permissions are defined.
     * Once this method has been overridden you need to run the
     * `fos:officialtext:installAces --flush` command
     *
     * @param  AclInterface $acl
     * @param  MaskBuilder  $builder
     * @return void
     */
    protected function doInstallFallbackAcl(AclInterface $acl, MaskBuilder $builder)
    {
        $builder->add('iddqd');
        $acl->insertClassAce(new RoleSecurityIdentity('ROLE_SUPER_ADMIN'), $builder->get());

        $builder->reset();
        $builder->add('view');
        $acl->insertClassAce(new RoleSecurityIdentity('IS_AUTHENTICATED_ANONYMOUSLY'), $builder->get());

        $builder->reset();
        $builder->add('create');
        $builder->add('view');
        $acl->insertClassAce(new RoleSecurityIdentity('ROLE_USER'), $builder->get());
    }

    /**
     * Removes fallback Acl entries for the Officialtext class.
     *
     * This should be run when uninstalling the OfficialtextBundle, or when
     * the Class Acl entry end up corrupted.
     *
     * @return void
     */
    public function uninstallFallbackAcl()
    {
        $oid = new ObjectIdentity('class', $this->officialtextClass);
        $this->aclProvider->deleteAcl($oid);
    }
}

