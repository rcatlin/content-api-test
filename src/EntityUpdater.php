<?php

namespace RCatlin\ContentApi;

use Assert\Assertion;
use Doctrine\ORM\EntityManager;
use RCatlin\ContentApi\Exception\MissingRequiredField;
use RCatlin\ContentApi\Exception\UpdateFailedException;

class EntityUpdater
{
    use ValidatesFieldType;

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
     *
     * @throws MissingRequiredField
     */
    public function update($entity, array $data)
    {
        Assertion::isObject($entity);

        return $this->doUpdate($entity, $data, false);
    }

    /**
     * @param object $entity
     * @param array $data
     *
     * @return object
     *
     * @throws MissingRequiredField
     */
    public function partial($entity, array $data)
    {
        Assertion::isObject($entity);

        return $this->doUpdate($entity, $data, true);
    }

    /**
     * @param object $entity
     * @param array $data
     * @param bool $partial
     * 
     * @return object
     *
     * @throws UpdateFailedException
     */
    public function doUpdate($entity, array $data, $partial)
    {
        Assertion::isObject($entity);
        Assertion::boolean($partial);

        $metaData = $this->entityManager->getClassMetadata(get_class($entity));
        $identifierFieldNames = $metaData->getIdentifierFieldNames();

        $invalidFieldNames = [];
        $missingRequiredFieldNames = [];

        foreach ($metaData->getFieldNames() as $fieldName) {
            // Skip Identifier Field Names
            if (in_array($fieldName, $identifierFieldNames)) {
                continue;
            }

            // Verify required and/or nullable fields
            if (!array_key_exists($fieldName, $data)) {
                // Skip over non-provided fields when partially updating
                if ($partial) {
                    continue;
                }

                $nullable = $metaData->fieldMappings[$fieldName]['nullable'];
                if (!$nullable) {
                    $missingRequiredFieldNames[] = $fieldName;
                    continue;
                }
            }

            $type = $metaData->fieldMappings[$fieldName]['type'];
            $validType = $this->validateFieldType($type, $data[$fieldName]);

            if (!$validType) {
                $invalidFieldNames[] = $fieldName;
                continue;
            }

            $metaData->setFieldValue($entity, $fieldName, $data[$fieldName]);
        }

        if (!empty($missingRequiredFieldNames) || !empty($invalidFieldNames)) {
            throw new UpdateFailedException($missingRequiredFieldNames, $invalidFieldNames);
        }

        return $entity;
    }
}
