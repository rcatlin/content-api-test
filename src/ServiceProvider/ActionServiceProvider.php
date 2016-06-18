<?php

namespace RCatlin\ContentApi\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\ContentApi\Action;

class ActionServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Action\PingAction::class
    ];

    public function register()
    {
        $this->container->share(Action\PingAction::class, function () {
           return new Action\PingAction();
        });
    }
}
