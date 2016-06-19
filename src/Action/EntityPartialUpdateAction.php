<?php

namespace RCatlin\ContentApi\Action;

use Assert\InvalidArgumentException;
use Doctrine\ORM\EntityManager;
use RCatlin\ContentApi\EntityClassName;
use RCatlin\ContentApi\EntityTransformer;
use RCatlin\ContentApi\EntityUpdater;
use RCatlin\ContentApi\RendersEntity;
use RCatlin\ContentApi\RendersError;
use Refinery29\Piston\ApiResponse;
use Refinery29\Piston\Request;
use Teapot\StatusCode;

class EntityPartialUpdateAction
{
    use RendersEntity;
    use RendersError;

    /**
     * @var EntityUpdater
     */
    private $entityUpdater;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(
        EntityUpdater $entityUpdater,
        EntityManager $entityManager,
        EntityTransformer $entityTransformer
    ) {
        $this->entityUpdater = $entityUpdater;
        $this->entityManager = $entityManager;
        $this->setEntityTransformer($entityTransformer);
    }

    public function update(Request $request, ApiResponse $response, array $vars = [])
    {
        $id = $vars['id'];

        unset($vars['id']);

        // Find Entity Class Name
        try {
            $className = EntityClassName::renderFromParts($vars);
        } catch (InvalidArgumentException $exception) {
            return $this->renderPathError($response);
        }

        // Lookup Existing Entity
        $entity = $this->entityManager->find($className, $id);
        if ($entity === null) {
            return $this->renderEntityNotFound($response, $id);
        }

        // Get Request Contents
        $content = json_decode($request->getBody()->getContents(), true);
        if (!is_array($content)) {
            return $this->renderError($response, StatusCode::BAD_REQUEST, 'Invalid Request JSON.', 0);
        }

        // Update
        try {
            $entity = $this->entityUpdater->partial($entity, $content);
        } catch (\Exception $exception) {
            return $this->renderError($response, StatusCode::INTERNAL_SERVER_ERROR, $exception->getMessage(), 0);
        }

        // Flush
        try {
            $this->entityManager->flush($entity);
        } catch (\Exception $exception) {
            $this->entityManager->rollback();
            return $this->renderError($response, StatusCode::INTERNAL_SERVER_ERROR, $exception->getMessage(), 0);
        }

        // Transform Entity
        return $this->renderEntity($response, StatusCode::ACCEPTED, $entity);
    }
}
