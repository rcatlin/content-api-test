<?php

namespace RCatlin\ContentApi\Action;

use Assert\InvalidArgumentException;
use Doctrine\ORM\EntityManager;
use RCatlin\ContentApi\EntityClassName;
use RCatlin\ContentApi\EntityTransformer;
use RCatlin\ContentApi\RendersEntity;
use RCatlin\ContentApi\RendersError;
use Refinery29\Piston\ApiResponse;
use Refinery29\Piston\Request;
use Teapot\StatusCode;

class EntityRetrieveAction
{
    use RendersEntity;
    use RendersError;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager, EntityTransformer $entityTransformer)
    {
        $this->entityManager = $entityManager;
        $this->setEntityTransformer($entityTransformer);
    }

    public function retrieve(Request $request, ApiResponse $response, array $vars = [])
    {
        $id = intval($vars['id']);

        unset($vars['id']);

        try {
            $className = EntityClassName::renderFromParts($vars);
        } catch (InvalidArgumentException $exception) {
            return $this->renderPathError($response);
        }

        $entity = $this->entityManager->find($className, $id);

        if ($entity === null) {
            return $this->renderEntityNotFound($response, $id);
        }

        return $this->renderEntity($response, StatusCode::OK, $entity);
    }
}
