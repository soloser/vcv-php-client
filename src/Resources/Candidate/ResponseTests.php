<?php

declare(strict_types=1);

namespace VcvApi\Resources\Candidate;

use VcvApi\Resources\Traits\DetailTrait;
use VcvApi\Resources\Traits\ListTrait;
use VcvApi\Resources\AbstractResource;

class ResponseTests extends AbstractResource
{
    use ListTrait, DetailTrait;

    protected function resourceName(): string
    {
        return 'tests/response';
    }
}
