<?php

namespace RCatlin\ContentApi;

use Assert\Assertion;
use Assert\InvalidArgumentException;

abstract class EntityClassName
{
    /**
     * @param array $parts
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public static function renderFromParts(array $parts)
    {
        $partialPath = implode('\\', array_map(function ($part) {
            return ucfirst($part);
        }, $parts));

        $className = 'RCatlin\\ContentApi\\Entity\\' . $partialPath;

        Assertion::classExists($className);

        return $className;
    }
}
