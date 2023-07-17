<?php

declare(strict_types=1);

namespace VcvApi\Resources\Traits;

use VcvApi\Exception\ResourceNotFoundException;
use VcvApi\Exception\RuntimeException;
use VcvApi\Request\ApiRequestInterface;

trait ListTrait
{
    use ResourceTrait;

    /**
     * List resources
     * @param ApiRequestInterface|null $apiRequest
     * @return array
     * @throws ResourceNotFoundException
     * @throws RuntimeException
     */
    public function list(ApiRequestInterface $apiRequest = null): array
    {
        return $this->getClient()->get(
            $this->resourceName(),
            $apiRequest !== null ? $apiRequest->getQueryParams() : []
        );
    }
}
