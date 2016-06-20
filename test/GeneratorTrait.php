<?php

namespace RCatlin\ContentApi\Test;

use Faker\Factory;
use Faker\Generator;

trait GeneratorTrait
{
    /**
     * @return Generator
     */
    protected static function getFaker()
    {
        $faker = Factory::create();
        $faker->seed(1985);

        return $faker;
    }
}
