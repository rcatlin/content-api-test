<?php

namespace RCatlin\ContentApi\Middleware;

use League\Pipeline\StageInterface;
use RCatlin\ContentApi\Action\PingAction;
use Refinery29\Piston\Middleware\Payload;
use Refinery29\Piston\Piston;

class Route implements StageInterface
{
    public function process($payload)
    {
        /** @var Payload $payload */
        /** @var Piston $subject */

        $subject = $payload->getSubject();

        $subject->get('api/ping', PingAction::class . '::' . 'ping');

        return $payload;
    }
}
