<?php

namespace RCatlin\ContentApi\Entity;

use Doctrine\ORM\Mapping as ORM;
use RCatlin\ContentApi\ChecksRequiredKeys;
use RCatlin\ContentApi\SetIfPresent;

/**
 * @ORM\Entity()
 * @ORM\Table(
 *     name="bars"
 * )
 */
class Bar
{
    use ChecksRequiredKeys;
    use HasIdentifier;
    use SetIfPresent;

    /**
     * @ORM\Column(
     *     name="fizz",
     *     type="integer"
     * )
     *
     * @var int
     */
    private $fizz;

    /**
     * @ORM\Column(
     *     name="buzz",
     *     type="string",
     *     nullable=true
     * )
     *
     * @var string
     */
    private $buzz;

    private function __construct()
    {}

    public static function fromArray(array $data)
    {
        self::checkRequiredKeys($data, ['fizz']);

        $bar = new self();

        $bar->setFizz($data['fizz']);
        
        $bar->setIfPresent($data, 'buzz', 'setBuzz');

        return $bar;
    }

    /**
     * @return string
     */
    public function getBuzz()
    {
        return $this->buzz;
    }

    /**
     * @param string $buzz
     */
    public function setBuzz($buzz)
    {
        $this->buzz = $buzz;
    }

    /**
     * @return int
     */
    public function getFizz()
    {
        return $this->fizz;
    }

    /**
     * @param int $fizz
     */
    public function setFizz($fizz)
    {
        $this->fizz = $fizz;
    }
}
