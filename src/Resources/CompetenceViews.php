<?php

declare(strict_types=1);

namespace VcvApi\Resources;

use VcvApi\Resources\Traits\DetailTrait;
use VcvApi\Resources\Traits\ListTrait;

class CompetenceViews extends AbstractResource
{
    use ListTrait, DetailTrait;

    protected function resourceName(): string
    {
        return 'competence-views';
    }
}
