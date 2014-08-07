<?php

namespace N1c0\OfficialtextBundle\Acl;

use N1c0\OfficialtextBundle\Model\OfficialtextInterface;

/**
 * Used for checking if the ACL system will allow specific actions
 * to occur.
 */
interface OfficialtextAclInterface
{
    /**
     * Checks if the user should be able to create a officialtext.
     *
     * @return boolean
     */
    public function canCreate();

    /**
     * Checks if the user should be able to view a officialtext.
     *
     * @param  OfficialtextInterface $officialtext
     * @return boolean
     */
    public function canView(OfficialtextInterface $officialtext);

    /**
     * Checks if the user can reply to the supplied 'parent' officialtext
     * or if not supplied, just the ability to reply.
     *
     * @param  OfficialtextInterface $officialtext
     * @return boolean
     */
    public function canReply(OfficialtextInterface $parent = null);

    /**
     * Checks if the user should be able to edit a officialtext.
     *
     * @param  OfficialtextInterface $officialtext
     * @return boolean
     */
    public function canEdit(OfficialtextInterface $officialtext);

    /**
     * Checks if the user should be able to delete a officialtext.
     *
     * @param  OfficialtextInterface $officialtext
     * @return boolean
     */
    public function canDelete(OfficialtextInterface $officialtext);

    /**
     * Sets the default Acl permissions on a officialtext.
     *
     * Note: this does not remove any existing Acl and should only
     * be called on new OfficialtextInterface instances.
     *
     * @param  OfficialtextInterface $officialtext
     * @return void
     */
    public function setDefaultAcl(OfficialtextInterface $officialtext);

    /**
     * Installs the Default 'fallback' Acl entries for generic access.
     *
     * @return void
     */
    public function installFallbackAcl();

    /**
     * Removes default Acl entries
     * @return void
     */
    public function uninstallFallbackAcl();
}
