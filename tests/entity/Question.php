<?php

// @link https://github.com/doctrine/doctrine2/issues/6790#issuecomment-384653528

namespace OpenstoreSchema\Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $label;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $complement;
}

