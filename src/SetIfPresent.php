<?php

namespace RCatlin\ContentApi;

use Assert\Assertion;

trait SetIfPresent
{
    /**
     * @param array $data
     * @param string $key
     * @param string $setterName
     */
    public function setIfPresent($data, $key, $setterName)
    {
        Assertion::string($key);
        Assertion::string($setterName);
        
        if (array_key_exists($key, $data)) {
            $this->$setterName($data[$key]);
        }
    }
}
