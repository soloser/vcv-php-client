<?php

declare(strict_types=1);

namespace VcvApi\Request;

interface ApiRequestInterface
{
    public function getQueryParams(): array;
}
