<?php

namespace OpenstoreSchema\Core\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(
 *   name="product_stub_translation",
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_legacy_mapping_idx",columns={"legacy_mapping"}),
 *     @ORM\UniqueConstraint(name="unique_translation_idx",columns={"product_stub_id", "lang"})
 *   },
 *   indexes={
 *     @ORM\Index(name="description_idx", columns={"description_header"}),
 *     @ORM\Index(name="keywords_idx", columns={"keywords"}),
 *     @ORM\Index(name="revision_idx", columns={"revision"}),
 *   },
 *   options={
 *      "comment" = "Product stub translation table",
 *   }
 * )
 *
 * "charset"="utf8mb4",
 * "collate"="utf8mb4_unicode_ci"
 */
class ProductStubTranslation
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="bigint", nullable=false, options={"unsigned"=true, "comment" = "Primary key"})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @ORM\ManyToOne(targetEntity="ProductStub", inversedBy="translations", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="product_stub_id", referencedColumnName="product_stub_id", onDelete="CASCADE", nullable=false)
     */
    private $product_stub_id;

    /**
     * @ORM\ManyToOne(targetEntity="Language", inversedBy="product_translations", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="lang", referencedColumnName="lang", onDelete="RESTRICT", nullable=false)
     * //options={"customSchemaOptions"={ "charset"="utf8" }})
     */
    private $lang;

    /**
     * @ORM\Column(type="string", length=5000, nullable=true, options={"comment" = "Description header that will be prepended to product desc"})
     */
    private $description_header;

    /**
     * @ORM\Column(type="string", length=5000, nullable=true, options={"comment" = "Description footer that will be appended to product desc"})
     */
    private $description_footer;


    /**
     * @ORM\Column(type="string", length=5000, nullable=true, options={"comment" = "Common product stub specifications"})
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
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param string $description_header
     */
    public function setDescriptionHeader($description_header)
    {
        $this->description_header = $description_header;
    }

    /**
     *
     * @param string $description_footer
     */
    public function setDescriptionFooter($description_footer)
    {
        $this->description_footer = $description_footer;
    }


    /**
     * @return string
     */
    public function getDescriptionHeader()
    {
        return $this->description_header;
    }


    /**
     * @return string
     */
    public function getDescriptionFooter()
    {
        return $this->description_footer;
    }


    /**
     *
     * @param string $specs
     */
    public function setSpecs($specs)
    {
        $this->specs = $specs;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getSpecs()
    {
        return $this->specs;
    }


    /**
     *
     * @param integer $product_stub_id
     */
    public function setProductStubId($product_stub_id)
    {
        $this->product_stub_id = $product_stub_id;
    }

    /**
     *
     * @return integer
     */
    public function getProductStubId()
    {
        return $this->product_stub_id;
    }


    /**
     *
     * @param integer $revision
     */
    public function setRevision($revision)
    {
        $this->revision = $revision;
    }

    /**
     *
     * @return integer
     */
    public function getRevision()
    {
        return $this->revision;
    }


    /**
     *
     * @param integer $lang_id
     */
    public function setLangId($lang_id)
    {
        $this->lang_id = $lang_id;
        return $this;
    }

    /**
     *
     * @return integer
     */
    public function getLangId()
    {
        return $this->lang_id;
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
        return $this;
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
        return $this;
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
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;
        return $this;
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
     */
    public function setUpdatedBy($updated_by)
    {
        $this->updated_by = $updated_by;
        return $this;
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
        return $this;
    }

    /**
     * Set legacy synchro time
     * @param string $legacy_synchro_at
     */
    public function setLegacySynchroAt($legacy_synchro_at)
    {
        $this->legacy_synchro_at = $legacy_synchro_at;
        return $this;
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
