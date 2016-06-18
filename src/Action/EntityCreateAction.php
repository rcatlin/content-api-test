<?php

namespace RCatlin\ContentApi\Action;

use Assert\InvalidArgumentException;
use Doctrine\ORM\EntityManager;
use RCatlin\ContentApi\EntityClassName;
use RCatlin\ContentApi\EntityHydrator;
use RCatlin\ContentApi\EntityTransformer;
use RCatlin\ContentApi\Exception\HydrationFailedException;
use RCatlin\ContentApi\RendersEntity;
use RCatlin\ContentApi\RendersError;
use Refinery29\Piston\ApiResponse;
use Refinery29\Piston\Request;
use Teapot\StatusCode;

class EntityCreateAction
{
    use RendersEntity;
    use RendersError;

    /**
     * @var EntityHydrator
     */
    private $entityHydrator;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(
        EntityHydrator $entityHydrator,
        EntityManager $entityManager,
        EntityTransformer $entityTransformer
    ) {
        $this->entityHydrator = $entityHydrator;
        $this->entityManager = $entityManager;
        $this->setEntityTransformer($entityTransformer);
    }

    public function create(Request $request, ApiResponse $response, array $vars = [])
    {
        // Find Entity Class Name
        try {
            $className = EntityClassName::renderFromParts($vars);
        } catch (InvalidArgumentException $exception) {
            return $this->renderPathError($response);
        }

        // Get Request Contents
        $content = json_decode($request->getBody()->getContents(), true);
        if (!is_array($content)) {
            return $this->renderError($response, StatusCode::BAD_REQUEST, 'Invalid Request JSON.', 0);
        }

        // Hydrate
        try {
            $entity = $this->entityHydrator->hydrate($className, $content);
        } catch (HydrationFailedException $exception) {
            return $this->renderHydrationErrors($response, $exception);
        } catch (\Exception $exception) {
            return $this->renderError($response, StatusCode::INTERNAL_SERVER_ERROR, $exception->getMessage(), 0);
        }

        // Persist
        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush($entity);
        } catch (\Exception $exception) {
            $this->entityManager->rollback();
            return $this->renderError($response, StatusCode::INTERNAL_SERVER_ERROR, $exception->getMessage(), 0);
        }

        // Transform Entity
        return $this->renderEntity($response, StatusCode::ACCEPTED, $entity);
    }
}
