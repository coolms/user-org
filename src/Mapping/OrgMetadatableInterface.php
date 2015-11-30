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

use Traversable,
    CmsOrg\Mapping\PositionInterface;

interface OrgMetadatableInterface
{
    /**
     * @param array|Traversable $metadata
     * @return self
     */
    public function setOrgMetadata($metadata);

    /**
     * @param array|Traversable|MetadataInterface $metadata
     * @return self
     */
    public function addOrgMetadata($metadata);

    /**
     * @param array|Traversable|MetadataInterface $metadata
     * @return self
     */
    public function removeOrgMetadata($metadata);

    /**
     * Removes all organization metadata
     *
     * @return self
     */
    public function clearOrgMetadata();

    /**
     * @param bool $current
     * @return MetadataInterface[]
     */
    public function getOrgMetadata($current = false);
}
