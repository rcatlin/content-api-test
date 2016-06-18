<?php

namespace RCatlin\ContentApi\Middleware;

use League\Pipeline\StageInterface;
use RCatlin\ContentApi\Action;
use RCatlin\ContentApi\Action\PingAction;
use Refinery29\Piston\Middleware\Payload;
use Refinery29\Piston\Piston;

class Route implements StageInterface
{
    const MAX_ENTITY_URL_PARTS = 4;

    public function process($payload)
    {
        /** @var Payload $payload */
        /** @var Piston $subject */

        $subject = $payload->getSubject();

        $subject->get('api/ping', PingAction::class . '::' . 'ping');

        for ($path = 'api', $i = 0; $i < self::MAX_ENTITY_URL_PARTS; $i++) {
            $path .= '/{part' . $i . '}';

            $subject->get($path . '/{id:number}', Action\EntityRetrieveAction::class . '::retrieve');
            $subject->post($path, Action\EntityCreateAction::class . '::create');
            $subject->delete($path . '/{id:number}', Action\EntityDeleteAction::class . '::delete');
        }

        return $payload;
    }
}
