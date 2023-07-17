<?php

declare(strict_types=1);

namespace VcvApi\Request\Traits;

trait RelationTrait
{
    public abstract function withRelation(string $relation): static;

    /**
     * @return $this
     */
    public function withUser(): static
    {
        $this->withRelation('user');
        return $this;
    }

    /**
     * @return $this
     */
    public function withVacancy(): static
    {
        $this->withRelation('vacancy');
        return $this;
    }

    /**
     * @return $this
     */
    public function withResponse(): static
    {
        $this->withRelation('response');
        return $this;
    }

    /**
     * @return $this
     */
    public function withCandidate(): static
    {
        $this->withRelation('candidate');
        return $this;
    }

    /**
     * @return $this
     */
    public function withAttribute(): static
    {
        $this->withRelation('attribute');
        return $this;
    }

    /**
     * @return $this
     */
    public function withInvite(): static
    {
        $this->withRelation('invite');
        return $this;
    }

    /**
     * @return $this
     */
    public function withInterview(): static
    {
        $this->withRelation('interview');
        return $this;
    }
}
