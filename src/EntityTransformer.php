<?php

namespace RCatlin\ContentApi;

use Assert\Assertion;
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

    /**
     * @param object $entity
     *
     * @return array
     */
    public function transform($entity)
    {
        Assertion::isObject($entity);

        $metaData = $this->entityManager->getClassMetadata(get_class($entity));

        $transformed = [];

        foreach ($metaData->getFieldNames() as $fieldName) {
            $transformed[$fieldName] = $metaData->getFieldValue($entity, $fieldName);
        }

        return $transformed;
    }
}
