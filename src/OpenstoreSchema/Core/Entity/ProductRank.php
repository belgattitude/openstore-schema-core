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
 *   name="product_rank",
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_product_rank_idx",columns={"product_id", "rankable_category_id", "pricelist_id", "brand_id"}),
 *   },
 *   indexes={
 *     @ORM\Index(name="deal_rank_idx", columns={"deal_rank"}),
 *     @ORM\Index(name="fresh_rank_idx", columns={"fresh_rank"}),
 *     @ORM\Index(name="bestseller_rank_idx", columns={"bestseller_rank"}),
 *     @ORM\Index(name="popular_rank_idx", columns={"popular_rank"}),
 *     @ORM\Index(name="trending_rank_idx", columns={"trending_rank"}),
 *     @ORM\Index(name="mostrated_rank_idx", columns={"mostrated_rank"}),
 *   },
 *   options={"comment" = "Product rankings"}
 * )
 */
class ProductRank
{
    /**
     * @ORM\Id
     * @ORM\Column(name="product_rank_id", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $product_rank_id;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="products", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="product_id", onDelete="CASCADE", nullable=false)
     */
    private $product_id;

    /**
     * @ORM\ManyToOne(targetEntity="ProductCategory", inversedBy="categories", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="rankable_category_id", referencedColumnName="category_id", onDelete="CASCADE", nullable=true)
     */
    private $rankable_category_id;

    /**
     * @ORM\ManyToOne(targetEntity="Pricelist", inversedBy="products", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="pricelist_id", referencedColumnName="pricelist_id", onDelete="CASCADE", nullable=true)
     */
    private $pricelist_id;

    /**
     * @ORM\ManyToOne(targetEntity="ProductBrand", inversedBy="products", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="brand_id", onDelete="CASCADE", nullable=true)
     */
    private $brand_id;

    /**
     * @ORM\Column(type="smallint", nullable=true, options={"unsigned"=true, "comment"="Notable deal product relative position in rankable category"})
     */
    private $deal_rank;

    /**
     * @ORM\Column(type="smallint", nullable=true, options={"unsigned"=true, "comment"="Fresh and shining product relative position in rankable category"})
     */
    private $fresh_rank;

    /**
     * @ORM\Column(type="smallint", nullable=true, options={"unsigned"=true, "comment"="Bestseller product relative position in rankable category"})
     */
    private $bestseller_rank;

    /**
     * @ORM\Column(type="smallint", nullable=true, options={"unsigned"=true, "comment"="Popular product relative position in rankable category"})
     */
    private $popular_rank;

    /**
     * @ORM\Column(type="smallint", nullable=true, options={"unsigned"=true, "comment"="Trending product relative position in rankable category"})
     */
    private $trending_rank;

    /**
     * @ORM\Column(type="smallint", nullable=true, options={"unsigned"=true, "comment"="Best rated product relative position in rankable category"})
     */
    private $mostrated_rank;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true, options={"comment"="Total recorded order line quantity (free period)"})
     */
    private $total_recorded_quantity;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true, options={"comment"="Total recorded turn over (free period)"})
     */
    private $total_recorded_turnover;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"unsigned"=true, "comment"="Number of distinct customers (free period)"})
     */
    private $nb_customers;

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
     * @param int $id
     */
    public function setId($id)
    {
        $this->product_rank_id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->product_rank_id;
    }

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @param int $product_id
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * @return int
     */
    public function getRankableCategoryId()
    {
        return $this->rankable_category_id;
    }

    /**
     * @param int $rankable_category_id
     */
    public function setRankableCategoryId($rankable_category_id)
    {
        $this->rankable_category_id = $rankable_category_id;
    }

    /**
     * @param int $pricelist_id
     */
    public function setPricelistId($pricelist_id)
    {
        $this->pricelist_id = $pricelist_id;
    }

    /**
     * @return int
     */
    public function getPricelistId()
    {
        return $this->pricelist_id;
    }

    /**
     * @param int $brand_id
     */
    public function setBrandId($brand_id)
    {
        $this->brand_id = $brand_id;
    }

    /**
     * @return int
     */
    public function getBrandId()
    {
        return $this->brand_id;
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
}
