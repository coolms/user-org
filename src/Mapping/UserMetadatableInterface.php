<?php
/**
 * CoolMS2 User Organization Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user-org for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUserOrg\Mapping;

use Doctrine\Common\Collections\Collection;

interface UserMetadatableInterface
{
    /**
     * @param array|\Traversable $metadata
     */
    public function setUserMetadata($metadata);

    /**
     * @param array|\Traversable|MetadataInterface $metadata
     */
    public function addUserMetadata($metadata);

    /**
     * @param array|\Traversable|MetadataInterface $metadata
     */
    public function removeUserMetadata($metadata);

    /**
     * Removes all user metadata
     */
    public function clearUserMetadata();

    /**
     * @return Collection
     */
    public function getUserMetadata();
}
