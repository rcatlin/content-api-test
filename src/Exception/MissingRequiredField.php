<?php

namespace RCatlin\ContentApi\Exception;

use Exception;

class MissingRequiredField extends Exception
{
    public function __construct($field, $code = 0, Exception $previous = null)
    {
        $message = 'Missing Required Field: ' . $field;
        parent::__construct($message, $code, $previous);
    }
}
