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
 *   name="product_translation",
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_legacy_mapping_idx",columns={"legacy_mapping"}),
 *     @ORM\UniqueConstraint(name="unique_translation_idx",columns={"product_id", "lang"})
 *   },
 *   indexes={
 *     @ORM\Index(name="title_idx", columns={"title"}),
 *     @ORM\Index(name="keywords_idx", columns={"keywords"}),
 *     @ORM\Index(name="slug_idx", columns={"slug"}),
 *     @ORM\Index(name="revision_idx", columns={"revision"}),
 *   },
 *   options={
 *      "comment" = "Product translation table",
 *      "charset"="utf8mb4",
 *      "collate"="utf8mb4_unicode_ci",
 *      "row_format" = "DYNAMIC"
 *   }
 * )
 */
class ProductTranslation
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="bigint", nullable=false, options={"unsigned"=true, "comment" = "Primary key"})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="translations", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="product_id", onDelete="CASCADE", nullable=false)
     */
    private $product_id;

    /**
     * @ORM\ManyToOne(targetEntity="Language", inversedBy="product_translations", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="lang", referencedColumnName="lang", onDelete="RESTRICT", nullable=false)
     * //options={"customSchemaOptions"={ "charset"="utf8" }})
     */
    private $lang;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=150, nullable=true, options={"comment" = "Unique slug for this record"})
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $invoice_title;

    /**
     * @ORM\Column(type="string", length=5000, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $characteristic;

    /**
     * @ORM\Column(type="text", nullable=true, options={"comment" = "Specifications"})
     */
    private $specs;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $keywords;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default"=1, "unsigned"=true, "comment" = "Translation revision number"})
     */
    private $revision;

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
     * @param string|int $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setCharacteristic(string $characteristic): void
    {
        $this->characteristic = $characteristic;
    }

    public function getCharacteristic(): string
    {
        return $this->characteristic;
    }

    /**
     * @param string $specs
     */
    public function setSpecs($specs)
    {
        $this->specs = $specs;
    }

    /**
     * @return string
     */
    public function getSpecs()
    {
        return $this->specs;
    }

    /**
     * @param int $product_id
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * @return int|string
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @param int $revision
     */
    public function setRevision($revision)
    {
        $this->revision = $revision;
    }

    /**
     * @return int
     */
    public function getRevision()
    {
        return $this->revision;
    }

    public function setLang(string $lang): void
    {
        $this->lang = $lang;
    }

    public function getLang(): string
    {
        return $this->lang;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    public function getCreatedBy(): ?string
    {
        return $this->created_by;
    }

    public function setCreatedBy(string $created_by): void
    {
        $this->created_by = $created_by;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->updated_by;
    }

    public function setUpdatedBy(string $updated_by): void
    {
        $this->updated_by = $updated_by;
    }

    public function getLegacyMapping(): ?string
    {
        return $this->legacy_mapping;
    }

    public function setLegacyMapping(string $legacy_mapping): void
    {
        $this->legacy_mapping = $legacy_mapping;
    }

    public function setLegacySynchroAt(string $legacy_synchro_at): void
    {
        $this->legacy_synchro_at = $legacy_synchro_at;
    }

    public function getLegacySynchroAt(): ?string
    {
        return $this->legacy_synchro_at;
    }

    public function __toString(): string
    {
        return $this->getTitle();
    }
}
