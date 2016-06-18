<?php

namespace RCatlin\ContentApi\Action;

use Refinery29\ApiOutput\Resource\ResourceFactory;
use Refinery29\Piston\ApiResponse;
use Refinery29\Piston\Request;

class PingAction
{
    public function ping(Request $request, ApiResponse $response, array $vars = [])
    {
        $response->setResult(
            ResourceFactory::result(['pong'])
        );

        return $response;
    }
}
