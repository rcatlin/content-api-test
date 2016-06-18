<?php

namespace RCatlin\ContentApi\Entity;

use Doctrine\ORM\Mapping as ORM;

trait HasIdentifier
{
    /**
     * @ORM\Id()
     * @ORM\Column(
     *     name="id",
     *     type="integer",
     *     options={"unsigned": true}
     * )
     * @ORM\GeneratedValue()
     *
     * @var int
     */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
