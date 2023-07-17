<?php

namespace VcvApi\Tests\Resources;

use VcvApi\Resources\AbstractResource;
use VcvApi\Resources\Traits\CreateTrait;
use VcvApi\Resources\Traits\DeleteTrait;
use VcvApi\Resources\Traits\DetailTrait;
use VcvApi\Resources\Traits\ListTrait;
use VcvApi\Resources\Traits\UpdateTrait;

final class FakeResource extends AbstractResource
{
    public const RESOURCE_NAME = 'fake';

    use ListTrait, DetailTrait, CreateTrait, UpdateTrait, DeleteTrait;

    protected function resourceName(): string
    {
        return self::RESOURCE_NAME;
    }
}