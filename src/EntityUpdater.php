<?php

namespace RCatlin\ContentApi;

use Assert\Assertion;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;

class EntityUpdater
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
     * @param array $data
     *
     * @return object
     */
    public function partial($entity, array $data)
    {
        Assertion::isObject($entity);

        $metaData = $this->entityManager->getClassMetadata(get_class($entity));
        $identifierFieldNames = $metaData->getIdentifierFieldNames();

        foreach ($metaData->getFieldNames() as $fieldName) {
            // Skip Identifier Field Names
            if (in_array($fieldName, $identifierFieldNames)) {
                continue;
            }

            if (!array_key_exists($fieldName, $data)) {
                continue;
            }

            $metaData->setFieldValue($entity, $fieldName, $data[$fieldName]);
        }

        return $entity;
    }
}
