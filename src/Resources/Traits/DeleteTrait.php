<?php

declare(strict_types=1);

namespace VcvApi\Resources\Traits;

use VcvApi\Exception\ResourceNotFoundException;
use VcvApi\Exception\RuntimeException;
use VcvApi\Exception\ValidationFailedException;
use VcvApi\Request\ApiRequestInterface;

trait DeleteTrait
{
    use ResourceTrait;

    /**
     * Delete resource by id
     * @param int $id
     * @param ApiRequestInterface|null $apiRequest
     * @return array
     * @throws ValidationFailedException
     * @throws ResourceNotFoundException
     * @throws RuntimeException
     */
    public function delete(int $id, ApiRequestInterface $apiRequest = null): array
    {
        return $this->getClient()->delete(
            $this->resourceName() . '/' . $id,
            $apiRequest !== null ? $apiRequest->getQueryParams() : []
        );
    }
}
