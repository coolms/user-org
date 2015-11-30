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

trait OrgMetadatableTrait
{
    /**
     * @var MetadataInterface[]
     *
     * @Form\ComposedObject({
     *      "target_object":"CmsUserOrg\Mapping\MetadataInterface",
     *      "is_collection":true,
     *      "options":{
     *          "name":"orgMetadata",
     *          "label":"User's jobs metadata",
     *          "count":0,
     *          "should_create_template":true,
     *          "allow_add":true,
     *          "allow_remove":true,
     *          "partial":"cms-user-org/metadata/fieldset",
     *      }})
     */
    protected $orgMetadata = [];

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
    public function setOrgMetadata($metadata)
    {
        $this->clearOrgMetadata();
        $this->addOrgMetadata($metadata);

        return $this;
    }

    /**
     * @param array|Traversable|MetadataInterface $metadata
     * @throws InvalidMetadataException
     * @return self
     */
    public function addOrgMetadata($metadata)
    {
        if ($metadata instanceof MetadataInterface) {
            $this->orgMetadata[] = $metadata;
            if (!$metadata->getUser()) {
            	$metadata->setUser($this);
            }
        } elseif (!is_array($metadata) && !$metadata instanceof Traversable) {
            throw InvalidMetadataException::invalidMetadataInstance($metadata);
        } else {
            foreach ($metadata as $data) {
                $this->addOrgMetadata($data);
            }
        }

        return $this;
    }

    /**
     * @param array|Traversable|MetadataInterface $metadata
     * @throws InvalidMetadataException
     * @return self
     */
    public function removeOrgMetadata($metadata)
    {
        if ($metadata instanceof MetadataInterface) {
            foreach ($this->orgMetadata as $key => $data) {
                if ($data === $metadata) {
                    unset($this->orgMetadata[$key]);
                }
            }
        } elseif (!is_array($metadata) && !$metadata instanceof Traversable) {
            throw InvalidMetadataException::invalidMetadataInstance($metadata);
        } else {
            foreach ($metadata as $meta) {
                $this->removeOrgMetadata($meta);
            }
        }

        return $this;
    }

    /**
     * Removes all user metadata
     *
     * @return self
     */
    public function clearOrgMetadata()
    {
        /* @var $data MetadataInterface */
        foreach ($this->orgMetadata as $data) {
            $this->removeOrgMetadata($data);
        }

        return $this;
    }

    /**
     * @param bool $current
     * @return MetadataInterface[]
     */
    public function getOrgMetadata($current = false)
    {
        if (!$current) {
            return $this->orgMetadata;
        }

        $meta = [];
        /* @var $data MetadataInterface */
        foreach ($this->orgMetadata as $key => $data) {
            if (null === $data->getExperience()->getEndDate()) {
                $meta[$key] = $data;
            }
        }

        return $meta;
    }
}
