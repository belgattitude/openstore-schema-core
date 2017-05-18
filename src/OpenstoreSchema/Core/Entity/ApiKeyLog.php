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
 *   name="api_key_log",
 *   uniqueConstraints={
 *   },
 *   options={
 *      "comment" = "Api usage logs",
 *      "charset"="utf8mb4",
 *      "collate"="utf8mb4_unicode_ci"
 *   }
 * )
 */
class ApiKeyLog
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="ApiKey", inversedBy="services", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="api_id", referencedColumnName="api_id", onDelete="CASCADE", nullable=false)
     */
    private $api_id;

    /**
     * @ORM\ManyToOne(targetEntity="ApiService", inversedBy="keys", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="service_id", referencedColumnName="service_id", onDelete="CASCADE", nullable=true)
     */
    private $service_id;

    /**
     * @ORM\Column(type="string", length=32, nullable=true, options={"comment" = "Remote api"})
     */
    private $remote_ip;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true, options={"comment" = "Record creation timestamp"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"comment" = "Custom message"})
     */
    private $message;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment" = "Time of execution in seconds", "unsigned"=true})
     */
    private $execution_time;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"comment" = "Size in bytes", "unsigned"=true})
     */
    private $network_usage;

    /**
     * @ORM\Column(type="integer", nullable=false, options={"default"=1, "unsigned"=true, "comment"="Count usage"})
     */
    private $usage_count;

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
     * @param int $api_id
     */
    public function setApiId($api_id)
    {
        $this->api_id = $api_id;
    }

    /**
     * @return int
     */
    public function getApiId()
    {
        return $this->api_id;
    }

    /**
     * @param int $service_id
     */
    public function setServiceId($service_id)
    {
        $this->service_id = $service_id;
    }

    /**
     * @return int
     */
    public function getServiceId()
    {
        return $this->service_id;
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
