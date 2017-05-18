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

/**
 * @ORM\Entity
 * @ORM\Table(
 *   name="product_stat_trend",
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_product_price_idx",columns={"pricelist_id", "product_id"}),
 *   },
 *   indexes={
 *     @ORM\Index(name="first_sale_recorded_at_idx", columns={"first_sale_recorded_at"}),
 *     @ORM\Index(name="latest_sale_recorded_at_idx", columns={"latest_sale_recorded_at"}),
 *     @ORM\Index(name="total_recorded_quantity_last_12_months_idx", columns={"total_recorded_quantity_last_12_months"}),
 *     @ORM\Index(name="total_recorded_turnover_last_12_months_idx", columns={"total_recorded_turnover_last_12_months"}),
 *   },
 *   options={"comment" = "Product sale trend stats"}
 * )
 */
class ProductStatTrend
{
    /**
     * @ORM\Id
     * @ORM\Column(name="product_stat_trend_id", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $product_stat_trend_id;

    /**
     * @ORM\ManyToOne(targetEntity="Pricelist", inversedBy="products", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="pricelist_id", referencedColumnName="pricelist_id", onDelete="CASCADE", nullable=false)
     */
    private $pricelist_id;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="products", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="product_id", onDelete="CASCADE", nullable=false)
     */
    private $product_id;

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
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct customers last month"})
     */
    private $nb_customers_last_month;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct sales reps last month"})
     */
    private $nb_sale_reps_last_month;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct orders last month"})
     */
    private $nb_orders_last_month;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true, options={"comment"="Total recorded order line quantity last month"})
     */
    private $total_recorded_quantity_last_month;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true, options={"comment"="Total recorded turn over last month"})
     */
    private $total_recorded_turnover_last_month;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct customers last month"})
     */
    private $nb_customers_last_2_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct sales reps last month"})
     */
    private $nb_sale_reps_last_2_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct orders last month"})
     */
    private $nb_orders_last_2_months;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true, options={"comment"="Total recorded order line quantity last month"})
     */
    private $total_recorded_quantity_last_2_months;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true, options={"comment"="Total recorded turn over last month"})
     */
    private $total_recorded_turnover_last_2_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct customers last month"})
     */
    private $nb_customers_last_3_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct sales reps last month"})
     */
    private $nb_sale_reps_last_3_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct orders last month"})
     */
    private $nb_orders_last_3_months;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true, options={"comment"="Total recorded order line quantity last month"})
     */
    private $total_recorded_quantity_last_3_months;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true, options={"comment"="Total recorded turn over last month"})
     */
    private $total_recorded_turnover_last_3_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct customers last month"})
     */
    private $nb_customers_last_4_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct sales reps last month"})
     */
    private $nb_sale_reps_last_4_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct orders last month"})
     */
    private $nb_orders_last_4_months;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true, options={"comment"="Total recorded order line quantity last month"})
     */
    private $total_recorded_quantity_last_4_months;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true, options={"comment"="Total recorded turn over last month"})
     */
    private $total_recorded_turnover_last_4_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct customers last month"})
     */
    private $nb_customers_last_5_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct sales reps last month"})
     */
    private $nb_sale_reps_last_5_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct orders last month"})
     */
    private $nb_orders_last_5_months;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true, options={"comment"="Total recorded order line quantity last month"})
     */
    private $total_recorded_quantity_last_5_months;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true, options={"comment"="Total recorded turn over last month"})
     */
    private $total_recorded_turnover_last_5_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct customers last month"})
     */
    private $nb_customers_last_6_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct sales reps last month"})
     */
    private $nb_sale_reps_last_6_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct orders last month"})
     */
    private $nb_orders_last_6_months;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true, options={"comment"="Total recorded order line quantity last month"})
     */
    private $total_recorded_quantity_last_6_months;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true, options={"comment"="Total recorded turn over last month"})
     */
    private $total_recorded_turnover_last_6_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct customers last 7 months"})
     */
    private $nb_customers_last_7_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct sales reps last 7 months"})
     */
    private $nb_sale_reps_last_7_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct orders last 7 months"})
     */
    private $nb_orders_last_7_months;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=7, nullable=true, options={"comment"="Total recorded order line quantity last 7 months"})
     */
    private $total_recorded_quantity_last_7_months;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=7, nullable=true, options={"comment"="Total recorded turn over last 7 months"})
     */
    private $total_recorded_turnover_last_7_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct customers last 8 months"})
     */
    private $nb_customers_last_8_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct sales reps last 8 months"})
     */
    private $nb_sale_reps_last_8_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct orders last 8 months"})
     */
    private $nb_orders_last_8_months;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=7, nullable=true, options={"comment"="Total recorded order line quantity last 8 months"})
     */
    private $total_recorded_quantity_last_8_months;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=7, nullable=true, options={"comment"="Total recorded turn over last 8 months"})
     */
    private $total_recorded_turnover_last_8_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct customers last 9 months"})
     */
    private $nb_customers_last_9_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct sales reps last 9 months"})
     */
    private $nb_sale_reps_last_9_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct orders last 9 months"})
     */
    private $nb_orders_last_9_months;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=7, nullable=true, options={"comment"="Total recorded order line quantity last 9 months"})
     */
    private $total_recorded_quantity_last_9_months;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=7, nullable=true, options={"comment"="Total recorded turn over last 9 months"})
     */
    private $total_recorded_turnover_last_9_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct customers last 10 months"})
     */
    private $nb_customers_last_10_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct sales reps last 10 months"})
     */
    private $nb_sale_reps_last_10_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct orders last 10 months"})
     */
    private $nb_orders_last_10_months;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=7, nullable=true, options={"comment"="Total recorded order line quantity last 10 months"})
     */
    private $total_recorded_quantity_last_10_months;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=7, nullable=true, options={"comment"="Total recorded turn over last 10 months"})
     */
    private $total_recorded_turnover_last_10_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct customers last 11 months"})
     */
    private $nb_customers_last_11_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct sales reps last 11 months"})
     */
    private $nb_sale_reps_last_11_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct orders last 11 months"})
     */
    private $nb_orders_last_11_months;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=7, nullable=true, options={"comment"="Total recorded order line quantity last 11 months"})
     */
    private $total_recorded_quantity_last_11_months;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=7, nullable=true, options={"comment"="Total recorded turn over last 11 months"})
     */
    private $total_recorded_turnover_last_11_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct customers last month"})
     */
    private $nb_customers_last_12_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct sales reps last month"})
     */
    private $nb_sale_reps_last_12_months;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment"="Number of distinct orders last month"})
     */
    private $nb_orders_last_12_months;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true, options={"comment"="Total recorded order line quantity last month"})
     */
    private $total_recorded_quantity_last_12_months;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true, options={"comment"="Total recorded turn over last month"})
     */
    private $total_recorded_turnover_last_12_months;

    /**
     * @ORM\Column(type="datetime",nullable=true, options={"comment" = "Last synchro timestamp"})
     */
    protected $legacy_synchro_at;

    /**
     * @param int $product_stat_trend_id
     */
    public function setId($product_stat_trend_id)
    {
        $this->product_stat_trend_id = $product_stat_trend_id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->product_stat_trend;
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
     * Set legacy synchro time.
     *
     * @param string $legacy_synchro_at
     */
    public function setLegacySynchroAt($legacy_synchro_at)
    {
        $this->legacy_synchro_at = $legacy_synchro_at;
    }
}
