<?php

declare(strict_types=1);

namespace VcvApi\Resources\Recruiter;

use VcvApi\Resources\Traits\DetailTrait;
use VcvApi\Resources\Traits\ListTrait;
use VcvApi\Resources\Traits\UpdateTrait;
use VcvApi\Resources\AbstractResource;

class VacancyVideointerviews extends AbstractResource
{
    use ListTrait, DetailTrait, UpdateTrait;

    protected function resourceName(): string
    {
        return 'videointerviews/vacancy';
    }
}
