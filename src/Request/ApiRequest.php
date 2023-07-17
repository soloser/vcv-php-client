<?php

declare(strict_types=1);

namespace VcvApi\Request;

class ApiRequest implements ApiRequestInterface
{

    /**
     * @param array $queryParams
     */
    public function __construct(private readonly array $queryParams = [])
    {

    }

    /**
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }
}
