<?php

declare(strict_types=1);

namespace VcvApi\Resources\Candidate;

use VcvApi\Resources\Traits\CreateTrait;
use VcvApi\Resources\Traits\DetailTrait;
use VcvApi\Resources\Traits\ListTrait;
use VcvApi\Resources\AbstractResource;

class Invites extends AbstractResource
{
    use ListTrait, DetailTrait, CreateTrait;

    protected function resourceName(): string
    {
        return 'invites';
    }
}
