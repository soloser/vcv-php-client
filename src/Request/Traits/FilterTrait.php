<?php

declare(strict_types=1);

namespace VcvApi\Request\Traits;

trait FilterTrait
{
    public abstract function filter(string $field, mixed $value): static;

    /**
     * Filter by resource id
     * @param int $id
     * @return $this
     */
    public function whereId(int $id): static
    {
        $this->filter('id', $id);
        return $this;
    }

    /**
     * Filter by resource active flag
     * @param bool $active
     * @return $this
     */
    public function whereActive(bool $active = true): static
    {
        $this->filter('active', $active);
        return $this;
    }

    /**
     * Filter by resource response_id field
     * @param int $id
     * @return $this
     */
    public function whereResponseId(int $id): static
    {
        $this->filter('response_id', $id);
        return $this;
    }

    /**
     * Filter by resource user_id field
     * @param int $id
     * @return $this
     */
    public function whereUserId(int $id): static
    {
        $this->filter('user_id', $id);
        return $this;
    }

    /**
     * Filter by resource vacancy_id field
     * @param int $id
     * @return $this
     */
    public function whereVacancyId(int $id): static
    {
        $this->filter('vacancy_id', $id);
        return $this;
    }

    /**
     * Filter by resource response_status_id field
     * @param int $id
     * @return $this
     */
    public function whereResponseStatusId(int $id): static
    {
        $this->filter('response_status_id', $id);
        return $this;
    }

    /**
     * Filter by resource email field
     * @param string $email
     * @return $this
     */
    public function whereEmail(string $email): static
    {
        $this->filter('email', $email);
        return $this;
    }

    /**
     * Filter by resource title field
     * @param string $title
     * @return $this
     */
    public function whereTitle(string $title): static
    {
        $this->filter('title', $title);
        return $this;
    }
}
