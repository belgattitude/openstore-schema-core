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
 *   name="media_video_file",
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_format_per_media",columns={"media_id", "format_reference"}),
 *   },
 *   options={
 *     "comment" = "Media video source files",
 *     "charset"="utf8mb4",
 *     "collate"="utf8mb4_unicode_ci"
 *   }
 * )
 */
class MediaVideoFile
{
    /**
     * @ORM\Id
     * @ORM\Column(name="video_source_id", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $video_source_id;

    /**
     * @ORM\ManyToOne(targetEntity="Media", inversedBy="medias", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="media_id", referencedColumnName="media_id", onDelete="CASCADE", nullable=false)
     */
    private $media_id;

    /**
     * @ORM\Column(type="string", length=80, nullable=true, options={"comment" = "Format reference for media file"})
     */
    private $format_reference;

    /**
     * @ORM\Column(type="string", length=385, nullable=true, options={"comment" = "Only for remote content (with a null container)"})
     */
    private $link_url;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $mimetype;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $video_width;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $video_height;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

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

    public function __construct()
    {
    }

    /**
     * @param int $media_id
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

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /**
     * @param string $updated_at
     */
    public function setUpdatedAt($updated_at): void
    {
        $this->updated_at = $updated_at;
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
}
