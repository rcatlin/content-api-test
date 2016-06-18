<?php

namespace RCatlin\ContentApi;

use RCatlin\ContentApi\Exception\MissingRequiredKeysException;

trait ChecksRequiredKeys
{
    /**
     * @param array $data
     * @param string[] $keys
     *
     * @throws MissingRequiredKeysException
     */
    public static function checkRequiredKeys(array $data, array $keys)
    {
        $missing = [];

        foreach ($keys as $key) {
            if (!array_key_exists($key, $data)) {
                $missing[] = $key;
            }
        }

        if (!empty($missing)) {
            throw new MissingRequiredKeysException($missing);
        }
    }
}
