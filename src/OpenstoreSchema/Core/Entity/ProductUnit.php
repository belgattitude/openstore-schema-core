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
 *   name="product_unit",
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_reference_idx",columns={"reference"}),
 *     @ORM\UniqueConstraint(name="unique_legacy_mapping_idx",columns={"legacy_mapping"}),
 *   },
 *   indexes={
 *     @ORM\Index(name="title_idx", columns={"title"}),
 *   },
 *   options={
 *     "comment" = "Product unit table",
 *     "charset"="utf8mb4",
 *     "collate"="utf8mb4_unicode_ci"
 *   }
 * )
 */
class ProductUnit
{
    /**
     * @ORM\OneToMany(targetEntity="ProductBrandTranslation", mappedBy="brand_id")
     * */
    private $translations;

    /**
     * @ORM\Id
     * @ORM\Column(name="unit_id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $unit_id;

    /**
     * @ORM\Column(type="string", length=10, nullable=false, options={"comment" = "Universal reference, kg, m3..."})
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=4, nullable=true, options={"comment" = "Symbol"})
     */
    private $symbol;

    /**
     * @ORM\Column(type="smallint", nullable=true, options={"default"=2, "unsigned"=true, "comment"="Number of decimals to display"})
     */
    private $display_decimals;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default"=1, "comment"="Whether the unit is active"})
     */
    private $flag_active;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $icon_class;

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
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
        /*
         * Default value for flag_active
         */
        $this->flag_active = true;
    }

    /**
     * @param int $unit_id
     */
    public function setUnitId($unit_id)
    {
        $this->unit_id = $unit_id;
    }

    /**
     * @return int
     */
    public function getUnitId()
    {
        return $this->unit_id;
    }

    /**
     * Set reference.
     *
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * Return reference.
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function setIconClass($icon_class)
    {
        $this->icon_class = $icon_class;
    }

    /**
     * @return string
     */
    public function getIconClass()
    {
        return $this->icon_class;
    }

    /**
     * @return int
     */
    public function getDisplayDecimals()
    {
        return $this->display_decimals;
    }

    /**
     * @param int $display_decimals
     */
    public function setDisplayDecimals($display_decimals)
    {
        $this->display_decimals = $display_decimals;
    }

    /**
     * Set symbol.
     *
     * @param string $symbol
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;
    }

    /**
     * Return symbol.
     *
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * @return bool
     */
    public function getFlagActive()
    {
        return (bool) $this->flag_active;
    }

    public function setFlagActive($flag_active)
    {
        $this->flag_active = $flag_active;
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

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }
}
