<?php

declare(strict_types=1);

namespace VcvApi\Resources\Traits;

use VcvApi\Http\Client;

trait ResourceTrait
{
    abstract protected function resourceName(): string;
    abstract protected function getClient(): Client;
}
