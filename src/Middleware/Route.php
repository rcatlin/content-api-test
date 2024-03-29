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

            $withNumericId = '/{id:number}';

            $subject->delete($path . $withNumericId, Action\EntityDeleteAction::class . '::delete');
            $subject->get($path . $withNumericId, Action\EntityRetrieveAction::class . '::retrieve');
            $subject->patch($path . $withNumericId, Action\EntityPartialUpdateAction::class . '::partial');
            $subject->post($path, Action\EntityCreateAction::class . '::create');
            $subject->put($path . $withNumericId, Action\EntityUpdateAction::class . '::update');
        }

        return $payload;
    }
}
