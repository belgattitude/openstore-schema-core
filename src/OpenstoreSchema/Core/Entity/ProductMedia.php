<?php

/*
 * opentore-schema-core
 *
 * @author    Vanvelthem Sébastien
 * @link      https://github.com/belgattitude/openstore-schema-core
 * @copyright Copyright (c) 2015-2017 Vanvelthem Sébastien
 * @license   MIT License, https://github.com/belgattitude/openstore-schema-core/blob/master/LICENSE.md
 *
 */

namespace OpenstoreSchema\Core\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(
 *   name="product_media",
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_product_media_type_idx",columns={"product_id", "media_id", "type_id"}),
 *     @ORM\UniqueConstraint(name="unique_product_type_flag_primary_idx",columns={"type_id", "product_id", "flag_primary"}),
 *   },
 *   indexes={
 *     @ORM\Index(name="sort_index_idx", columns={"sort_index"}),
 *   },
 *   options={
 *     "comment" = "Product media table",
 *     "charset"="utf8mb4",
 *     "collate"="utf8mb4_unicode_ci"
 *   }
 * )
 */
class ProductMedia
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="products", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="product_id", onDelete="CASCADE", nullable=false)
     */
    private $product_id;

    /**
     * @ORM\ManyToOne(targetEntity="Media", inversedBy="products", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="media_id", referencedColumnName="media_id", onDelete="CASCADE", nullable=false)
     */
    private $media_id;

    /**
     * @ORM\ManyToOne(targetEntity="ProductMediaType", inversedBy="products", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="type_id", referencedColumnName="type_id", onDelete="CASCADE", nullable=false)
     */
    private $type_id;

    /**
     * @ORM\Column(name="flag_primary", type="boolean", nullable=true)
     */
    private $flag_primary;

    /**
     * @ORM\Column(name="sort_index", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $sort_index;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true, options={"comment" = "Record creation timestamp"})
     */
    private $created_at;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true, options={"comment" = "Record last update timestamp"})
     */
    private $updated_at;

    /**
     * @Gedmo\Blameable(on="create")
     * @ORM\Column(type="string", length=40, nullable=true, options={"comment" = "Creator name"})
     */
    private $created_by;

    /**
     * @Gedmo\Blameable(on="update")
     * @ORM\Column(type="string", length=40, nullable=true, options={"comment" = "Last updater name"})
     */
    private $updated_by;

    /**
     * @ORM\Column(type="string",length=40,nullable=true, options={"comment" = "Unique reference of this record taken from legacy system"})
     */
    protected $legacy_mapping;

    /**
     * @ORM\Column(type="datetime",nullable=true, options={"comment" = "Last synchro timestamp"})
     */
    protected $legacy_synchro_at;

    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $product_id
     *
     * @return \OpenstoreSchema\Core\Entity\ProductMedia
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @param int $media_id
     *
     * @return \OpenstoreSchema\Core\Entity\ProductMedia
     */
    public function setMediaId($media_id)
    {
        $this->media_id = $media_id;
    }

    /**
     * @return int
     */
    public function getMediaId()
    {
        return $this->media_id;
    }

    /**
     * @param int $type_id
     *
     * @return \OpenstoreSchema\Core\Entity\ProductMedia
     */
    public function setTypeId($type_id)
    {
        $this->type_id = $type_id;
    }

    /**
     * @return int
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * @return int
     */
    public function getSortIndex()
    {
        return $this->sort_index;
    }

    /**
     * @param int $sort_index
     */
    public function setSortIndex($sort_index)
    {
        $this->sort_index = $sort_index;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param string $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * Return creator username.
     *
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * Set creator username.
     *
     * @param string $created_by
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;
    }

    /**
     * Return last updater username.
     *
     * @return string
     */
    public function getUpdatedBy()
    {
        return $this->updated_by;
    }

    /**
     * Set the last updater username.
     *
     * @param string $updated_by
     */
    public function setUpdatedBy($updated_by)
    {
        $this->updated_by = $updated_by;
    }

    /**
     * Return legacy mapping.
     *
     * @return string $legacy_mapping
     */
    public function getLegacyMapping()
    {
        return $this->legacy_mapping;
    }

    /**
     * Set a legacy mapping for this record.
     *
     * @param string $legacy_mapping
     */
    public function setLegacyMapping($legacy_mapping)
    {
        $this->legacy_mapping = $legacy_mapping;
    }

    /**
     * Set legacy synchro time.
     *
     * @param string $legacy_synchro_at
     */
    public function setLegacySynchroAt($legacy_synchro_at)
    {
        $this->legacy_synchro_at = $legacy_synchro_at;
    }

    /**
     * Return legacy synchro timestamp.
     *
     * @return string
     */
    public function getLegacySynchroAt()
    {
        return $this->legacy_synchro_at;
    }
}
