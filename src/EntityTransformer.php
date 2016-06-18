<?php

namespace RCatlin\ContentApi;

use Doctrine\ORM\EntityManager;

class EntityTransformer
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function serialize()
}
