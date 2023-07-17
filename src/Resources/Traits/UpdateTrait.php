<?php

declare(strict_types=1);

namespace VcvApi\Resources\Traits;

use VcvApi\Exception\ApiLimitExceededException;
use VcvApi\Exception\ResourceNotFoundException;
use VcvApi\Exception\RuntimeException;
use VcvApi\Exception\ValidationFailedException;
use VcvApi\Request\ApiRequestInterface;

trait UpdateTrait
{
    use ResourceTrait;

    /**
     * @param int $id
     * @param array $body
     * @param ApiRequestInterface|null $apiRequest
     * @return array
     * @throws ValidationFailedException
     * @throws ApiLimitExceededException
     * @throws ResourceNotFoundException
     * @throws RuntimeException
     */
    public function update(int $id, array $body, ApiRequestInterface $apiRequest = null): array
    {
        return $this->getClient()->patch(
            $this->resourceName() . '/' . $id,
            $body,
            $apiRequest !== null ? $apiRequest->getQueryParams() : []
        );
    }
}
