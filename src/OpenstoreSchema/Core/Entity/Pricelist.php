<?php

namespace OpenstoreSchema\Core\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(
 *   name="pricelist",
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_reference_idx",columns={"reference"}),
 *     @ORM\UniqueConstraint(name="unique_legacy_mapping_idx",columns={"legacy_mapping"}),
 *     @ORM\UniqueConstraint(name="unique_flag_default_idx",columns={"flag_default"}),
 *     @ORM\UniqueConstraint(name="sort_index_idx",columns={"sort_index"})
 *   },
 *   options={"comment" = "Pricelist table"}
 * )
 */
class Pricelist
{

    /**
     * @ORM\Id
     * @ORM\Column(name="pricelist_id", type="smallint", nullable=false, options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $pricelist_id;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Stock", inversedBy="stocks", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="stock_id", referencedColumnName="stock_id", onDelete="CASCADE", nullable=false)
     */
    private $stock_id;

    /**
     *
     * @ORM\ManyToOne(targetEntity="PricelistGroup", inversedBy="groups", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="group_id", referencedColumnName="group_id", onDelete="CASCADE", nullable=true)
     */
    private $group_id;



    /**
     *
     * @ORM\ManyToOne(targetEntity="Currency", inversedBy="pricelists", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="currency_id", nullable=false)
     */
    private $currency_id;

    /**
     * When dealing with product_rank use this one instead pricelist_id
     *
     * @ORM\ManyToOne(targetEntity="Pricelist")
     * @ORM\JoinColumn(name="rank_pricelist_id", referencedColumnName="pricelist_id", onDelete="CASCADE", nullable=true)
     */
    private $rank_pricelist_id;

    /**
     * When dealing with pricelist condition, use this pricelist_id instead of pricelist
     * @ORM\ManyToOne(targetEntity="Pricelist")
     * @ORM\JoinColumn(name="discount_condition_pricelist_id", referencedColumnName="pricelist_id", onDelete="CASCADE", nullable=true)
     */
    private $discount_condition_pricelist_id;

    /**
     * @ORM\Column(type="string", length=10, nullable=false, options={"comment" = "Unique pricelist reference"})
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=15000, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default"=1, "comment"="Whether this pricelist must honour special discount conditions"})
     */
    private $flag_enable_discount_condition;


    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default"=null, "comment"="Whether this pricelist is default"})
     */
    private $flag_default;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default"=1, "comment"="Whether the pricelist is public"})
     */
    private $flag_public;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default"=1, "comment"="Whether the brand is active in public website"})
     */
    private $flag_active;


    /**
     * @ORM\Column(type="smallint", nullable=true, options={"unsigned"=true, "comment" = "Flag products as new if more recent than the number of days"})
     */
    private $cond_product_new_max_days;


    /**
     * @ORM\Column(type="integer", nullable=true, options={"unsigned"=true, "comment"="Relative sort index"})
     */
    private $sort_index;

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
        /**
         * Default value for flag_active
         */
        $this->flag_active = true;
    }

    /**
     *
     * @param integer $pricelist_id
     */
    public function setPricelistId($pricelist_id)
    {
        $this->pricelist_id = $pricelist_id;
    }

    /**
     *
     * @return integer
     */
    public function getPricelistId()
    {
        return $this->pricelist_id;
    }

    /**
     *
     * @param Currency $currency_id
     */
    public function setCurrency(Currency $currency_id)
    {
        $this->currency_id = $currency_id;
    }

    /**
     *
     * @return integer
     */
    public function getCurrencyId()
    {
        return $this->currency_id;
    }

    /**
     *
     * @param Stock $stock_id
     */
    public function setStock(Stock $stock_id)
    {
        $this->stock_id = $stock_id;
    }

    /**
     *
     * @return Stock
     */
    public function getStock()
    {
        return $this->stock_id;
    }

    /**
     * Set reference
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * Return reference
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     *
     * @return string
     */
    public function setIconClass($icon_class)
    {
        $this->icon_class = $icon_class;
    }


    /**
     *
     * @param integer $sort_index
     * @return Pricelist
     */
    public function setSortIndex($sort_index)
    {
        $this->sort_index = $sort_index;
    }

    /**
     *
     * @return integer
     */
    public function getSortIndex()
    {
        return $this->sort_index;
    }


    /**
     *
     * @return string
     */
    public function getIconClass()
    {
        return $this->icon_class;
    }

    /**
     *
     * @return boolean
     */
    public function getFlagActive()
    {
        return (boolean) $this->flag_active;
    }

    /**
     * @return Pricelist
     */
    public function setFlagActive($flag_active)
    {
        $this->flag_active = $flag_active;
    }

    /**
     *
     * @return boolean
     */
    public function getFlagPublic()
    {
        return (boolean) $this->flag_public;
    }


    /**
     * @return Pricelist
     */
    public function setFlagEnableDiscountCondition($flag_enable_discount_condition)
    {
        $this->flag_enable_discount_condition = $flag_enable_discount_condition;
    }

    /**
     *
     * @return boolean
     */
    public function getFlagEnableDiscountCondition()
    {
        return (boolean) $this->flag_enable_discount_condition;
    }


    /**
     * @return Pricelist
     */
    public function setFlagPublic($flag_public)
    {
        $this->flag_public = $flag_public;
    }

    /**
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     *
     * @param string $created_at
     * @return Pricelist
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     *
     * @param string $updated_at
     * @return Pricelist
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * Return creator username
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * Set creator username
     * @param string $created_by
     * @return Pricelist
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;
    }

    /**
     * Return last updater username
     * @return string
     */
    public function getUpdatedBy()
    {
        return $this->updated_by;
    }

    /**
     * Set the last updater username
     * @param string $updated_by
     * @return Pricelist
     */
    public function setUpdatedBy($updated_by)
    {
        $this->updated_by = $updated_by;
    }

    /**
     * Return legacy mapping
     * @return string $legacy_mapping
     */
    public function getLegacyMapping()
    {
        return $this->legacy_mapping;
    }

    /**
     * Set a legacy mapping for this record
     * @param string $legacy_mapping
     */
    public function setLegacyMapping($legacy_mapping)
    {
        $this->legacy_mapping = $legacy_mapping;
    }

    /**
     * Set legacy synchro time
     * @param string $legacy_synchro_at
     */
    public function setLegacySynchroAt($legacy_synchro_at)
    {
        $this->legacy_synchro_at = $legacy_synchro_at;
    }

    /**
     * Return legacy synchro timestamp
     * @return string
     */
    public function getLegacySynchroAt()
    {
        return $this->legacy_synchro_at;
    }
}
