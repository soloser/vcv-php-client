<?php

declare(strict_types=1);

namespace VcvApi\Resources\Traits;

use VcvApi\Exception\ResourceNotFoundException;
use VcvApi\Exception\RuntimeException;
use VcvApi\Request\ApiRequestInterface;

trait DetailTrait
{
    use ResourceTrait;

    /**
     * Retrieve resource by id
     * @param int $id
     * @param ApiRequestInterface|null $apiRequest
     * @return array
     * @throws ResourceNotFoundException
     * @throws RuntimeException
     */
    public function getById(int $id, ApiRequestInterface $apiRequest = null): array
    {
        return $this->getClient()->get(
            $this->resourceName() . '/' . $id,
            $apiRequest !== null ? $apiRequest->getQueryParams() : []
        );
    }
}
