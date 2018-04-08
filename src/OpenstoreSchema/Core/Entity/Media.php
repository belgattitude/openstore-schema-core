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
 *   name="media",
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_legacy_mapping_idx",columns={"legacy_mapping"}),
 *     @ORM\UniqueConstraint(name="unique_container_location_idx",columns={"container_id", "location"}),
 *     @ORM\UniqueConstraint(name="unique_remote_media_id_idx",columns={"type_id", "remote_media_id"}),
 *   },
 *   indexes={
 *     @ORM\Index(name="title_idx", columns={"title"}),
 *   },
 *   options={
 *     "comment" = "Media table",
 *     "charset"="utf8mb4",
 *     "collate"="utf8mb4_unicode_ci",
 *     "row_format" = "DYNAMIC"
 *   }
 * )
 * @Gedmo\SoftDeleteable(fieldName="deleted_at")
 */
class Media
{
    /**
     * @ORM\Id
     * @ORM\Column(name="media_id", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $media_id;

    /**
     * @ORM\ManyToOne(targetEntity="MediaType", inversedBy="medias", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="type_id", referencedColumnName="type_id", onDelete="CASCADE", nullable=true)
     */
    private $type_id;

    /**
     * @ORM\ManyToOne(targetEntity="MediaContainer", inversedBy="medias", cascade={"persist", "remove"})
     * @ORM\JoinColumn( name="container_id",
     *                  referencedColumnName="container_id",
     *                  onDelete="CASCADE",
     *                  nullable=true
     *                )
     */
    private $container_id;

    /**
     * @ORM\Column(type="string", length=385, nullable=true, options={"comment" = "Only for remote content (with a null container)"})
     */
    private $remote_media_url;

    /**
     * @ORM\Column(type="string", length=64, nullable=true, options={"comment" = "External media id, only for remote content (with a null container)"})
     */
    private $remote_media_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"comment" = "Remote media image preview url"})
     */
    private $remote_preview_url;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $mimetype;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    private $filename;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @ORM\Column(type="bigint", nullable=true, options={"comment" = "Filesize in bytes", "unsigned" = true})
     */
    private $filesize;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment" = "Video duration in seconds", "unsigned" = true})
     */
    private $duration;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"unsigned" = true})
     */
    private $filemtime;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

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
     * @ORM\Column(type="datetime", nullable=true, options={"comment" = "Record deletion date"})
     */
    private $deleted_at;

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
     * @param int $media_id
     *
     * @return \OpenstoreSchema\Core\Entity\Media
     */
    public function setMediaId($media_id)
    {
        $this->media_id = $media_id;
    }

    /**
     * @return int
     */
    public function getMediaId()
    {
        return $this->media_id;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
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
     * @return int
     */
    public function getFilesize()
    {
        return $this->filesize;
    }

    /**
     * @param int $filesize
     */
    public function setFilesize($filesize)
    {
        $this->filesize = $filesize;
    }

    /**
     * @return int
     */
    public function getFilemtime()
    {
        return $this->filemtime;
    }

    /**
     * @param int $filemtime
     */
    public function setFilemtime($filemtime)
    {
        $this->filemtime = $filemtime;
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
     * @return string
     */
    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    /**
     * @param string $deleted_at
     */
    public function setDeletedAt($deleted_at)
    {
        $this->deleted_at = $deleted_at;
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
