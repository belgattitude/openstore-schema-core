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

use Doctrine\Common\Annotations\Annotation\Attributes;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(
 *   name="product_attribute",
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_product_idx",columns={"product_id"}),
 *   },
 *   indexes={
 *   },
 *   options={
 *     "comment" = "Product attributes table",
 *     "charset"="utf8mb4",
 *     "collate"="utf8mb4_unicode_ci",
 *   }
 * )
 */
class ProductAttribute
{
    /**
     * @ORM\Id
     * @ORM\Column(name="product_attribute_id", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $product_attribute_id;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="children")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="product_id", onDelete="CASCADE", nullable=false)
     */
    private $product_id;


    /**
     * Attributes
     * @ORM\Column(type="json", nullable=true, options={"comment" = "Json attributes"})
     */
    private $attributes;

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

    public function __construct()
    {
    }

    public function setProductId(int $product_id): void
    {
        $this->product_id = $product_id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
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
