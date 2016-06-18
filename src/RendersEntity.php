<?php

namespace RCatlin\ContentApi;

use Assert\Assertion;
use Refinery29\ApiOutput\Resource\ResourceFactory;
use Refinery29\Piston\ApiResponse;

trait RendersEntity
{
    /**
     * @var EntityTransformer
     */
    protected $entityTransformer;

    public function setEntityTransformer(EntityTransformer $entityTransformer)
    {
        $this->entityTransformer = $entityTransformer;
    }

    /**
     * @param ApiResponse $response
     * @param int $statusCode
     * @param object $entity
     *
     * @return ApiResponse
     */
    public function renderEntity(ApiResponse $response, $statusCode, $entity)
    {
        Assertion::integer($statusCode);
        Assertion::isObject($entity);

        $response->setResult(
            ResourceFactory::result(
                $this->entityTransformer->transform($entity)
            )
        );

        return $response->withStatus($statusCode);
    }
}
