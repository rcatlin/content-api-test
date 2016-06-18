<?php

namespace RCatlin\ContentApi\Entity;

use Assert\Assertion;
use Doctrine\ORM\Mapping as ORM;
use RCatlin\ContentApi\ChecksRequiredKeys;

/**
 * @ORM\Entity()
 * @ORM\Table(name="foos")
 */
class Foo
{
    use ChecksRequiredKeys;
    use HasIdentifier;
    
    const NAME_MAX_LENGTH = 100;
    const VALUE_MAX_LENGTH = 255;

    /**
     * @ORM\Column(
     *     name="name",
     *     type="string",
     *     length=100
     * )
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(
     *     name="value",
     *     type="string",
     *     length=255
     * )
     *
     * @var string
     */
    private $value;

    private function __construct()
    {}

    public static function fromArray(array $data)
    {
        self::checkRequiredKeys($data, ['name', 'value']);

        $foo = new self();

        $foo->setName($data['name']);
        $foo->setValue($data['value']);

        return $foo;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        Assertion::string($name);
        Assertion::maxLength($name, self::NAME_MAX_LENGTH);

        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        Assertion::string($value);
        Assertion::maxLength($value, self::VALUE_MAX_LENGTH);

        $this->value = $value;
    }
}
