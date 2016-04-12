<?php

namespace OpenstoreSchema\Core\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(
 *   name="product_pricelist_stat",
 *   options={"comment" = "Product pricelist quick statistics"}
 * )
 */
class ProductPricelistStat
{

    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="ProductPricelist")
     * @ORM\JoinColumn(name="product_pricelist_stat_id", nullable=false, referencedColumnName="product_pricelist_id", onDelete="CASCADE")
     */
    private $product_pricelist_stat_id;

    /**
     * @ORM\Column(type="decimal", precision=16, scale=6, nullable=true, options={"comment"="Forecasted monthly sales quantity"})
     */
    private $forecasted_monthly_sales;

    /**
     * @ORM\Column(type="date", nullable=true, options={"comment" = "First recorded sale at"})
     */
    private $first_sale_recorded_at;

    /**
     * @ORM\Column(type="date", nullable=true, options={"comment" = "Latest recorded sale at"})
     */
    private $latest_sale_recorded_at;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct customers"})
     */
    private $nb_customers;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct sales reps"})
     */
    private $nb_sale_reps;


    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct orders"})
     */
    private $nb_orders;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true, options={"comment"="Total recorded order line quantity"})
     */
    private $total_recorded_quantity;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true, options={"comment"="Total recorded turn over"})
     */
    private $total_recorded_turnover;

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
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->product_pricelist_stat_id = $id;
    }

    /**
     *
     * @return integer
     */
    public function getId()
    {
        return $this->product_pricelist_stat_id;
    }

    /**
     *
     * @param integer $product_pricelist_id
     */
    public function setProduct_PricelistId($product_pricelist_id)
    {
        $this->product_pricelist_id = $product_pricelist_id;
    }

    /**
     *
     * @return integer
     */
    public function getProductPricelistId()
    {
        return $this->product_pricelist_id;
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
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }
}
