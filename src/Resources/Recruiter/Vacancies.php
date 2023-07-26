<?php

declare(strict_types=1);

namespace VcvApi\Resources\Recruiter;

use VcvApi\Resources\Traits\CreateTrait;
use VcvApi\Resources\Traits\DeleteTrait;
use VcvApi\Resources\Traits\DetailTrait;
use VcvApi\Resources\Traits\ListTrait;
use VcvApi\Resources\Traits\UpdateTrait;
use VcvApi\Resources\AbstractResource;

use function array_map;

class Vacancies extends AbstractResource
{
    use ListTrait, DetailTrait, CreateTrait, UpdateTrait, DeleteTrait;

    public function archiveList(array $ids): array
    {
        return $this->getClient()->patch($this->resourceName(), [
            'vacancies' => array_map(function (int $id): array {
                return [
                    'id' => $id,
                    'active' => false,
                ];
            }, $ids),
        ]);
    }

    public function deleteList(array $ids): array
    {
        return $this->getClient()->delete($this->resourceName(), [], [
            'vacancies' => array_map(function (int $id): array {
                return [
                    'id' => $id,
                ];
            }, $ids),
        ]);
    }

    public function restoreList(array $ids): array
    {
        return $this->getClient()->patch($this->resourceName(), [
            'vacancies' => array_map(function (int $id): array {
                return [
                    'id' => $id,
                    'active' => true,
                ];
            }, $ids),
        ]);
    }

    protected function resourceName(): string
    {
        return 'vacancies';
    }
}
