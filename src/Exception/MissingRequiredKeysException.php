<?php

namespace RCatlin\ContentApi\Exception;

use Exception;

class MissingRequiredKeysException extends Exception
{
    public function __construct(array $keys, $code = 0, Exception $previous = null)
    {
        $message = 'Missing Required Keys: ' . implode(', ', $keys);

        parent::__construct($message, $code, $previous);
    }
}
