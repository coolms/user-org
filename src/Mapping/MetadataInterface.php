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

use CmsCommon\Mapping\Common\AnnotatableInterface,
    CmsCommon\Mapping\Common\DescribableInterface,
    CmsCommon\Mapping\Common\VerifiableInterface,
    CmsOrg\Mapping\OrganizationableInterface,
    CmsOrg\Mapping\PositionableInterface,
    CmsUser\Mapping\UserableInterface;

interface MetadataInterface extends
    AnnotatableInterface,
    DescribableInterface,
    VerifiableInterface,
    OrganizationableInterface,
    PositionableInterface,
    UserableInterface
{
    /**
     * @return ExperienceInterface
     */
    public function getExperience();
}
