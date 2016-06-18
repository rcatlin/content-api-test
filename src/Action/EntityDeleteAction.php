<?php

namespace RCatlin\ContentApi\Action;

use Assert\InvalidArgumentException;
use Doctrine\ORM\EntityManager;
use RCatlin\ContentApi\EntityClassName;
use RCatlin\ContentApi\RendersEntity;
use RCatlin\ContentApi\RendersError;
use Refinery29\Piston\ApiResponse;
use Refinery29\Piston\Request;
use Teapot\StatusCode;

class EntityDeleteAction
{
    use RendersEntity;
    use RendersError;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function delete(Request $request, ApiResponse $response, array $vars = [])
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

        try {
            $this->entityManager->remove($entity);
            $this->entityManager->flush();
        } catch (\Exception $exception) {
            return $this->renderError(
                $response,
                StatusCode::INTERNAL_SERVER_ERROR,
                'Error occurred deleting Resource.',
                0
            );
        }

        return $response->withStatus(StatusCode::ACCEPTED);
    }
}
