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
 *   name="permission",
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_name_idx",columns={"name"}),
 *   },
 *   indexes={
 *     @ORM\Index(name="name_idx", columns={"name"}),
 *   },
 *   options={
 *     "comment" = "Custom permissions",
 *     "charset"="utf8mb4",
 *     "collate"="utf8mb4_unicode_ci"
 *   }
 * )
 */
class Permission
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="permission_id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $permission_id;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $name;

    /**
     * Constructor.
     */
    public function __construct($name)
    {
        $this->name = (string) $name;
    }

    /**
     * Get the permission identifier.
     *
     * @return int
     */
    public function getId()
    {
        return $this->permission_id;
    }

    /**
     * Get the permission identifier.
     *
     * @return int
     */
    public function getPermissionId()
    {
        return $this->permission_id;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->name;
    }
}
