<?php

namespace RCatlin\ContentApi\Test;

use League\Container\Container;

trait ContainerAware
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @return Container
     */
    public function getContainer()
    {
        if ($this->container === null) {
            $this->container = require __DIR__ . '/../config/container.php';
        }

        return $this->container;
    }
}
