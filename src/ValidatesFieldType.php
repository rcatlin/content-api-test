<?php

namespace RCatlin\ContentApi;

use Assert\Assertion;
use InvalidArgumentException;

trait ValidatesFieldType
{
    /**
     * @param string $type
     * @param mixed $value
     *
     * @return bool
     */
    public function validateFieldType($type, $value)
    {
        Assertion::string($type);

        try {
            switch ($type) {
                case 'string':
                    Assertion::string($value);
                    break;
                case 'integer':
                    Assertion::integer($value);
                    break;
                default:
                    return true;
            }
        } catch (InvalidArgumentException $exception) {
            return false;
        }

        return true;
    }
}
