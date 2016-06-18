<?php

namespace RCatlin\ContentApi;

use Refinery29\ApiOutput\Resource\ResourceFactory;
use Refinery29\Piston\ApiResponse;

trait RenderError
{
    public function renderError(ApiResponse $response, $title, $code = 0)
    {
        $response->setErrors(
            ResourceFactory::errorCollection([
                ResourceFactory::error($title, $code)
            ])
        );
    }
}
