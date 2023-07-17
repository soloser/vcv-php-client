<?php

declare(strict_types=1);

namespace VcvApi\Request;

use VcvApi\Request\Traits\FilterTrait;
use VcvApi\Request\Traits\RelationTrait;

class ApiRequestBuilder
{
    use FilterTrait;
    use RelationTrait;

    private ?array $with = null;
    private ?array $filter = null;
    private ?array $fields = null;
    private ?string $sortBy = null;
    private ?string $sortOrder = null;
    private ?int $page = null;
    private ?int $pageSize = null;

    /**
     * @param string $relation
     * @return static
     */
    public function withRelation(string $relation): static
    {
        if (!in_array($relation, $this->with ?? [])) {
            $this->with[] = $relation;
        }
        return $this;
    }

    /**
     * @param string $field
     * @param mixed $value
     * @return static
     */
    public function filter(string $field, mixed $value): static
    {
        $this->filter[$field] = $value;
        return $this;
    }

    /**
     * @param array $with
     * @return static
     */
    public function setWith(array $with): static
    {
        $this->with = $with;
        return $this;
    }

    /**
     * @param array $filter
     * @return static
     */
    public function setFilter(array $filter): static
    {
        $this->filter = $filter;
        return $this;
    }

    /**
     * @param string $sortBy
     * @return static
     */
    public function setSortBy(string $sortBy): static
    {
        $this->sortBy = $sortBy;
        return $this;
    }

    /**
     * @param string $sortOrder
     * @return static
     */
    public function setSortOrder(string $sortOrder): static
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    /**
     * @param int $page
     * @return static
     */
    public function setPage(int $page): static
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @param int $pageSize
     * @return static
     */
    public function setPageSize(int $pageSize): static
    {
        $this->pageSize = $pageSize;
        return $this;
    }

    /**
     * @param array $fields
     * @return static
     */
    public function setFields(array $fields): static
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * @param string $field
     * @return static
     */
    public function withField(string $field): static
    {
        if (!in_array($field, $this->fields ?? [])) {
            $this->fields[] = $field;
        }
        return $this;
    }

    /**
     * @return ApiRequest
     */
    public function getRequest(): ApiRequest
    {
        $queryParams = [];
        if ($this->filter !== null) {
            $queryParams['filter'] = $this->filter;
        }
        if ($this->with !== null) {
            $queryParams['with'] = $this->with;
        }
        if ($this->fields !== null) {
            $queryParams['fields'] = $this->fields;
        }
        if ($this->sortBy !== null) {
            $queryParams['sort']['by'] = $this->sortBy;
        }
        if ($this->sortOrder !== null) {
            $queryParams['sort']['order'] = $this->sortOrder;
        }
        if ($this->page !== null) {
            $queryParams['page'] = $this->page;
        }
        if ($this->pageSize !== null) {
            $queryParams['limit'] = $this->pageSize;
        }

        return new ApiRequest($queryParams);
    }
}
