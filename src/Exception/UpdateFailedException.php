<?php

namespace RCatlin\ContentApi\Exception;

use Assert\Assertion;
use Exception;

class UpdateFailedException extends Exception
{
    /**
     * @var string[]
     */
    private $missingRequiredFieldNames = [];

    /**
     * @var string[]
     */
    private $invalidFieldNames = [];

    /**
     * @param string[] $missingRequiredFieldNames
     * @param string[] $invalidFieldNames
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($missingRequiredFieldNames, $invalidFieldNames, $code = 0, Exception $previous = null)
    {
        Assertion::allString($invalidFieldNames);
        Assertion::allString($missingRequiredFieldNames);

        $this->invalidFieldNames = $invalidFieldNames;
        $this->missingRequiredFieldNames = $missingRequiredFieldNames;

        parent::__construct('An exception occurred updating an Entity.', $code, $previous);
    }

    /**
     * @return string[]
     */
    public function getInvalidFieldNames()
    {
        return $this->invalidFieldNames;
    }

    /**
     * @return string[]
     */
    public function getMissingRequiredFieldNames()
    {
        return $this->missingRequiredFieldNames;
    }
}
