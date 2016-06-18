<?php

namespace RCatlin\ContentApi;

use Assert\Assertion;
use Doctrine\ORM\EntityManager;
use InvalidArgumentException;
use RCatlin\ContentApi\Exception\HydrationFailedException;

class EntityHydrator
{
    const VALID = 0;
    const MISSING_REQUIRED = 1;
    const INVALID = 2;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function hydrate($className, array $data)
    {
        Assertion::classExists($className);

        $metaData = $this->entityManager->getClassMetadata($className);
        $identifierFieldNames = $metaData->getIdentifierFieldNames();

        $missingRequiredFieldNames = [];
        $invalidFieldNames = [];

        foreach ($metaData->fieldMappings as $fieldMapping) {
            $fieldName = $fieldMapping['fieldName'];

            // Skip Identifiers
            if (in_array($fieldName, $identifierFieldNames)) {
                continue;
            }

            $result = $this->validateFieldMapping($fieldMapping, $data);

            if ($result === self::VALID) {
                continue;
            }

            if ($result == self::MISSING_REQUIRED) {
                $missingRequiredFieldNames[] = $fieldName;
                continue;
            }

            if ($result === self::INVALID) {
                $invalidFieldNames[] = $fieldName;
                continue;
            }

            throw new \Exception('Uncovered field mapping validation case.');
        }

        if (!empty($missingRequiredFieldNames) || !empty($invalidFieldNames)) {
            throw new HydrationFailedException($missingRequiredFieldNames, $invalidFieldNames);
        }

        return call_user_func($className . '::fromArray', $data);
    }

    private function validateFieldMapping($fieldMapping, $data)
    {
        $fieldName = $fieldMapping['fieldName'];
        $nullable = $fieldMapping['nullable'];

        if ($nullable && !array_key_exists($fieldName, $data)) {
            return self::VALID;
        }

        if (!$nullable && !array_key_exists($fieldName, $data)) {
            return self::MISSING_REQUIRED;
        }

        $value = $data[$fieldName];

        try {
            switch ($fieldMapping['type']) {
                case 'string':
                    Assertion::string($value);
                    break;
                case 'integer':
                    Assertion::integer($value);
                    break;
                default:
                    return self::VALID;
            }
        } catch (InvalidArgumentException $exception) {
            return self::INVALID;
        }

        return self::VALID;
    }
}
