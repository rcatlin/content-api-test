<?php

namespace RCatlin\ContentApi;

use Assert\Assertion;
use RCatlin\ContentApi\Exception\HydrationFailedException;
use RCatlin\ContentApi\Exception\UpdateFailedException;
use Refinery29\ApiOutput\Resource\Error\Error;
use Refinery29\ApiOutput\Resource\ResourceFactory;
use Refinery29\Piston\ApiResponse;
use Teapot\StatusCode;

trait RendersError
{
    /**
     * @param ApiResponse $response
     * @param int $statusCode
     * @param string $title
     * @param int $code
     * 
     * @return ApiResponse
     */
    public function renderError(ApiResponse $response, $statusCode, $title, $code = 0)
    {
        Assertion::integer($statusCode);
        Assertion::string($title);
        Assertion::integer($code);

        $response->setErrors(
            ResourceFactory::errorCollection([
                ResourceFactory::error($title, $code)
            ])
        );

        return $response->withStatus($statusCode);
    }

    /**
     * @param ApiResponse $response
     * @param int $statusCode
     * @param array $errors
     *
     * @return ApiResponse
     */
    public function renderErrors(ApiResponse $response, $statusCode, array $errors)
    {
        Assertion::integer($statusCode);
        Assertion::allIsInstanceOf($errors, Error::class);

        $response->setErrors(
            ResourceFactory::errorCollection($errors)
        );

        return $response->withStatus($statusCode);
    }

    public function renderHydrationErrors(ApiResponse $response, HydrationFailedException $exception)
    {
        $errors = [];

        foreach ($exception->getInvalidFieldNames() as $invalidFieldName) {
            $errors[] = ResourceFactory::error('Invalid field: ' . $invalidFieldName, 0);
        }

        foreach ($exception->getMissingRequiredFieldNames() as $missingRequiredFieldName) {
            $errors[] = ResourceFactory::error('Missing required field: ' . $missingRequiredFieldName, 0);
        }

        return $this->renderErrors($response, StatusCode::BAD_REQUEST, $errors);
    }

    public function renderEntityNotFound(ApiResponse $response, $id)
    {
        Assertion::integer($id);

        return $this->renderError(
            $response,
            StatusCode::NOT_FOUND,
            'Entity with id "' . $id . '" was not found."',
            0
        );
    }
    public function renderPathError(ApiResponse $response)
    {
        return $this->renderError($response, StatusCode::NOT_FOUND, 'Entity path not found.', 0);
    }

    public function renderUpdateErrors(ApiResponse $response, UpdateFailedException $exception)
    {
        $errors = [];

        foreach ($exception->getInvalidFieldNames() as $invalidFieldName) {
            $errors[] = ResourceFactory::error('Invalid field: ' . $invalidFieldName, 0);
        }

        foreach ($exception->getMissingRequiredFieldNames() as $missingRequiredFieldName) {
            $errors[] = ResourceFactory::error('Missing required field: ' . $missingRequiredFieldName, 0);
        }

        return $this->renderErrors($response, StatusCode::BAD_REQUEST, $errors);
    }
}
