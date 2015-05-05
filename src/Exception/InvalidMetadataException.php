<?php
/**
 * CoolMS2 User Organization Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user-org for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUserOrg\Exception;

/**
 * Invalid metadata exception for CmsUserOrg
 */
class InvalidMetadataException extends InvalidArgumentException
{
    /**
     * @param mixed $metadata
     * @return self
     */
    public static function invalidMetadataInstance($metadata)
    {
        return new self(
            sprintf(
                'Expected argument of type array or instance of Traversable '
                    . 'or CmsUserOrg\Mapping\MetadataInterface, %s given',
                is_object($metadata)
                    ? get_class($metadata)
                    : gettype($metadata)
            )
        );
    }
}
