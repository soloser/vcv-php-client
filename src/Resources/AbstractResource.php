<?php

declare(strict_types=1);

namespace VcvApi\Resources;

use VcvApi\Http\Client;

abstract class AbstractResource
{

    public function __construct(private Client $client)
    {
    }

    protected function getClient(): Client
    {
        return $this->client;
    }
}
