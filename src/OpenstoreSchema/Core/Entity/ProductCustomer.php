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
 *   name="product_customer",
 *   uniqueConstraints={
 *   },
 *   indexes={
 *     @ORM\Index(name="product_id_idx", columns={"product_id"}),
 *     @ORM\Index(name="customer_id_idx", columns={"customer_id"}),
 *   },
 *   options={
 *     "comment" = "Reserved product for customers",
 *     "charset"="utf8mb4",
 *     "collate"="utf8mb4_unicode_ci"
 *   }
 * )
 */
class ProductCustomer
{
    /**
     * @ORM\Id
     * @ORM\Column(name="product_id", type="bigint", nullable=false)
     */
    private $product_id;

    /**
     * @ORM\Id
     * @ORM\Column(name="customer_id", type="integer", nullable=false)
     */
    private $customer_id;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $legacy_synchro_at;

    public function __construct()
    {
    }

    /**
     * @param int $customer_id
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
     * @param int $customer_id
     */
    public function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;
    }

    /**
     * @return int
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * @param string $legacy_synchro_at
     */
    public function setLegacySynchroAt($legacy_synchro_at)
    {
        $this->legacy_synchro_at = $legacy_synchro_at;
    }

    /**
     * @return string
     */
    public function getLegacySynchroAt()
    {
        return $this->legacy_synchro_at;
    }
}
