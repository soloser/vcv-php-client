<?php

declare(strict_types=1);

namespace VcvApi\Resources;

use VcvApi\Exception\RuntimeException;
use VcvApi\Resources\Traits\DetailTrait;
use VcvApi\Resources\Traits\ListTrait;

class Users extends AbstractResource
{
    use ListTrait, DetailTrait;

    /**
     * Retrieve current user info
     * @return array
     * @throws RuntimeException
     */
    public function me(): array
    {
        return $this->getClient()->get('user');
    }

    protected function resourceName(): string
    {
        return 'users';
    }
}
