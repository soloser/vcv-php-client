<?php

declare(strict_types=1);

namespace VcvApi\Resources\Candidate;

use VcvApi\Resources\Traits\CreateTrait;
use VcvApi\Resources\Traits\DeleteTrait;
use VcvApi\Resources\Traits\DetailTrait;
use VcvApi\Resources\Traits\ListTrait;
use VcvApi\Resources\Traits\UpdateTrait;
use VcvApi\Resources\AbstractResource;

class ResponseAttributeValues extends AbstractResource
{
    use ListTrait, DetailTrait, CreateTrait, UpdateTrait, DeleteTrait;

    protected function resourceName(): string
    {
        return 'response-attribute-values';
    }
}
