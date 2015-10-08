<?php
/**
 * CoolMS2 User Organization Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user-org for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUserOrg\Mapping\Traits;

use ArrayObject,
    Traversable,
    CmsUserOrg\Exception\InvalidMetadataException,
    CmsUserOrg\Mapping\MetadataInterface;

trait UserMetadatableTrait
{
    /**
     * @var MetadataInterface[]
     *
     * @Form\Exclude()
     */
    protected $userMetadata = [];

    /**
     * __construct
     *
     * Initializes metadata
     */
    public function __construct()
    {
        $this->userMetadata = new ArrayObject($this->userMetadata);
    }

    /**
     * @param array|Traversable $metadata
     */
    public function setUserMetadata($metadata)
    {
        $this->clearUserMetadata();
        $this->addUserMetadata($metadata);
    }

    /**
     * @param array|Traversable|MetadataInterface $metadata
     * @throws InvalidMetadataException
     */
    public function addUserMetadata($metadata)
    {
        if ($metadata instanceof MetadataInterface) {
            $this->orgMetadata[] = $metadata;
            if (!$metadata->getOrganization()) {
                $metadata->setOrganization($this);
            }
        } elseif (!is_array($metadata) && !$metadata instanceof Traversable) {
            throw InvalidMetadataException::invalidMetadataInstance($metadata);
        } else {
            foreach ($metadata as $data) {
                $this->addUserMetadata($data);
            }
        }
    }

    /**
     * @param array|Traversable|MetadataInterface $metadata
     * @throws InvalidMetadataException
     */
    public function removeUserMetadata($metadata)
    {
        if ($metadata instanceof MetadataInterface) {
            foreach ($this->userMetadata as $key => $data) {
                if ($data === $metadata) {
                    unset($this->userMetadata[$key]);
                }
            }
        } elseif (!is_array($metadata) && !$metadata instanceof Traversable) {
            throw InvalidMetadataException::invalidMetadataInstance($metadata);
        } else {
            foreach ($metadata as $data) {
                $this->removeUserMetadata($data);
            }
        }
    }

    /**
     * Removes all user metadata
     */
    public function clearUserMetadata()
    {
        foreach ($this->userMetadata as $data) {
            $this->removeUserMetadata($data);
        }
    }

    /**
     * @return MetadataInterface[]
     */
    public function getUserMetadata()
    {
        return $this->userMetadata;
    }
}
