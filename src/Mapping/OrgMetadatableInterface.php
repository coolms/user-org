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

use CmsOrg\Mapping\PositionInterface;

interface OrgMetadatableInterface
{
    /**
     * @param array|\Traversable $metadata
     */
    public function setOrgMetadata($metadata);

    /**
     * @param array|\Traversable|MetadataInterface $metadata
     */
    public function addOrgMetadata($metadata);

    /**
     * @param array|\Traversable|MetadataInterface $metadata
     */
    public function removeOrgMetadata($metadata);

    /**
     * Removes all organization metadata
     */
    public function clearOrgMetadata();

    /**
     * @param bool $current
     * @return MetadataInterface[]
     */
    public function getOrgMetadata($current = false);
}
