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
        $id = $vars['id'];

        unset($vars['id']);

        try {
            $className = EntityClassName::renderFromParts($vars);
        } catch (InvalidArgumentException $exception) {
            var_dump($exception);die();
            return $this->renderPathError($response);
        }

        $entity = $this->entityManager->find($className, $id);

        if ($entity === null) {
            return $this->renderError(
                $response,
                StatusCode::NOT_FOUND,
                'Entity with id "' . $id . '" was not found."',
                0
            );
        }

        return $this->renderEntity($response, StatusCode::OK, $entity);
    }
}
