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
 *   name="product_stock",
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_product_price_idx",columns={"stock_id", "product_id"}),
 *     @ORM\UniqueConstraint(name="unique_legacy_mapping_idx",columns={"legacy_mapping"}),
 *   },
 *   indexes={
 *     @ORM\Index(name="available_stock_idx", columns={"available_stock"}),
 *     @ORM\Index(name="theoretical_stock_idx", columns={"theoretical_stock"}),
 *   },
 *   options={
 *     "comment" = "Product stock",
 *     "charset"="utf8mb4",
 *     "collate"="utf8mb4_unicode_ci"
 *   }
 * )
 */
class ProductStock
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Stock", inversedBy="products", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="stock_id", referencedColumnName="stock_id", onDelete="CASCADE", nullable=false)
     */
    private $stock_id;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="products", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="product_id", onDelete="CASCADE", nullable=false)
     */
    private $product_id;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=6, nullable=false, options={"comment"="Available stock"})
     */
    private $available_stock;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=6, nullable=true, options={"comment"="Theoretical stock"})
     */
    private $theoretical_stock;

    /**
     * @ORM\Column(type="datetime", nullable=true, options={"comment"="Next stock arrival date"})
     */
    private $next_available_stock_at;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=6, nullable=true, options={"comment"="Next available stock"})
     */
    private $next_available_stock;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=6, nullable=true, options={"comment"="Average monthly sales for this product / pricelist"})
     */
    private $avg_monthly_sale_qty;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true, options={"comment" = "Record last update timestamp"})
     */
    private $updated_at;

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
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getAvailableStock()
    {
        return $this->available_stock;
    }

    /**
     * @param float $available_stock
     *
     * @return ProductPricelist
     */
    public function setAvailableStock($available_stock)
    {
        $this->available_stock = $available_stock;
    }

    /**
     * @param float $theoretical_stock
     *
     * @return ProductPricelist
     */
    public function setTheoreticalStock($theoretical_stock)
    {
        $this->theoretical_stock = $theoretical_stock;
    }

    /**
     * @return float
     */
    public function getTheoreticalStock()
    {
        return $this->theoretical_stock;
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
     * Magic getter to expose protected properties.
     *
     * @param string $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        return $this->$property;
    }

    /**
     * Magic setter to save protected properties.
     *
     * @param string $property
     * @param mixed  $value
     */
    public function __set($property, $value)
    {
        $this->$property = $value;
    }
}
