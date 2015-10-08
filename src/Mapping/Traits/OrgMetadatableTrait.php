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
        $this->orgMetadata = new ArrayObject($this->orgMetadata);
    }

    /**
     * @param array|Traversable $metadata
     */
    public function setOrgMetadata($metadata)
    {
        $this->clearOrgMetadata();
        $this->addOrgMetadata($metadata);
    }

    /**
     * @param array|Traversable|MetadataInterface $metadata
     * @throws InvalidMetadataException
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
    }

    /**
     * @param array|Traversable|MetadataInterface $metadata
     * @throws InvalidMetadataException
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
    }

    /**
     * Removes all user metadata
     */
    public function clearOrgMetadata()
    {
        foreach ($this->orgMetadata as $data) {
            $this->removeOrgMetadata($data);
        }
    }

    /**
     * @return MetadataInterface[]
     */
    public function getOrgMetadata()
    {
        return $this->orgMetadata;
    }
}
