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

use Traversable,
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
        
    }

    /**
     * @param array|Traversable $metadata
     * @return self
     */
    public function setUserMetadata($metadata)
    {
        $this->clearUserMetadata();
        $this->addUserMetadata($metadata);

        return $this;
    }

    /**
     * @param array|Traversable|MetadataInterface $metadata
     * @throws InvalidMetadataException
     * @return self
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

        return $this;
    }

    /**
     * @param array|Traversable|MetadataInterface $metadata
     * @throws InvalidMetadataException
     * @return self
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

        return $this;
    }

    /**
     * Removes all user metadata
     *
     * @return self
     */
    public function clearUserMetadata()
    {
        foreach ($this->userMetadata as $data) {
            $this->removeUserMetadata($data);
        }

        return $this;
    }

    /**
     * @return MetadataInterface[]
     */
    public function getUserMetadata()
    {
        return $this->userMetadata;
    }
}
