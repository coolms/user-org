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
    Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection,
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
        $this->userMetadata = new ArrayCollection();
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
            $this->getUserMetadata()->add($metadata);
        } elseif (!is_array($metadata) && !$metadata instanceof Traversable) {
            throw InvalidMetadataException::invalidMetadataInstance($metadata);
        }

        foreach ($metadata as $data) {
            $this->addUserMetadata($data);
        }
    }

    /**
     * @param array|Traversable|MetadataInterface $metadata
     * @throws InvalidMetadataException
     */
    public function removeUserMetadata($metadata)
    {
        if ($metadata instanceof MetadataInterface) {
            $this->getUserMetadata()->removeElement($metadata);
        } elseif (!is_array($metadata) && !$metadata instanceof Traversable) {
            throw InvalidMetadataException::invalidMetadataInstance($metadata);
        }

        foreach ($metadata as $data) {
            $this->removeUserMetadata($data);
        }
    }

    /**
     * Removes all user metadata
     */
    public function clearUserMetadata()
    {
        $this->getUserMetadata()->clear();
    }

    /**
     * @return Collection
     */
    public function getUserMetadata()
    {
        return $this->userMetadata;
    }
}
