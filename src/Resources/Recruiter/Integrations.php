<?php

declare(strict_types=1);

namespace VcvApi\Resources\Recruiter;

use VcvApi\Resources\Traits\CreateTrait;
use VcvApi\Resources\Traits\DetailTrait;
use VcvApi\Resources\Traits\ListTrait;
use VcvApi\Resources\Traits\UpdateTrait;
use VcvApi\Resources\AbstractResource;

class Integrations extends AbstractResource
{
    use ListTrait, DetailTrait, CreateTrait, UpdateTrait;

    protected function resourceName(): string
    {
        return 'integration/vacancy';
    }
}
