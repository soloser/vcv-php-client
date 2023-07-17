<?php

declare(strict_types=1);

namespace VcvApi\Tests\Resources;

use PHPUnit\Framework\TestCase;
use VcvApi\Request\ApiRequestBuilder;

class RequestBuilderTest extends TestCase
{

    public function testEmptyQueryParams(): void
    {
        $request = (new ApiRequestBuilder())
            ->getRequest();
        $this->assertEmpty($request->getQueryParams());
    }

    public function testFilterParam(): void
    {
        $filter = ['test' => 123];
        $builder = (new ApiRequestBuilder())
            ->setFilter($filter);
        $this->assertEquals($filter, $builder->getRequest()->getQueryParams()['filter']);
    }

    public function testWithParam(): void
    {
        $with = ['vacancy', 'response'];
        $builder = (new ApiRequestBuilder())
            ->setWith($with);
        $this->assertEquals($with, $builder->getRequest()->getQueryParams()['with']);
    }

    public function testSortBy(): void
    {
        $sortBy = 'id';
        $builder = (new ApiRequestBuilder())
            ->setSortBy($sortBy);
        $this->assertEquals($sortBy, $builder->getRequest()->getQueryParams()['sort']['by']);
    }

    public function testSortOrder(): void
    {
        $sort = 'desc';
        $builder = (new ApiRequestBuilder())
            ->setSortOrder($sort);
        $this->assertEquals($sort, $builder->getRequest()->getQueryParams()['sort']['order']);
    }

    public function testPage(): void
    {
        $page = 123;
        $builder = (new ApiRequestBuilder())
            ->setPage(123);
        $this->assertEquals($page, $builder->getRequest()->getQueryParams()['page']);
    }

    public function testPageSize(): void
    {
        $pageSize = 15;
        $builder = (new ApiRequestBuilder())
            ->setPageSize($pageSize);
        $this->assertEquals($pageSize, $builder->getRequest()->getQueryParams()['limit']);
    }

    public function testFields(): void
    {
        $fields = ['vacancy_id', 'response_id'];
        $builder = (new ApiRequestBuilder())
            ->setFields($fields);
        $this->assertEquals($fields, $builder->getRequest()->getQueryParams()['fields']);
    }

    public function testField(): void
    {
        $fields = ['vacancy_id', 'response_id'];
        $builder = new ApiRequestBuilder();
        foreach ($fields as $field) {
            $builder->withField($field);
        }
        $this->assertEquals($fields, $builder->getRequest()->getQueryParams()['fields']);
    }

    public function testNotUniqueFields(): void
    {
        $fields = ['vacancy_id', 'vacancy_id', 'response_id'];
        $builder = new ApiRequestBuilder();
        foreach ($fields as $field) {
            $builder->withField($field);
        }
        $this->assertEquals(['vacancy_id', 'response_id'], $builder->getRequest()->getQueryParams()['fields']);
    }

    public function testWithRelation(): void
    {
        $fields = ['vacancy', 'interview'];
        $builder = new ApiRequestBuilder();
        foreach ($fields as $field) {
            $builder->withRelation($field);
        }
        $this->assertEquals($fields, $builder->getRequest()->getQueryParams()['with']);
    }

    public function testNotUniqueWithRelation(): void
    {
        $fields = ['vacancy', 'interview', 'vacancy'];
        $builder = new ApiRequestBuilder();
        foreach ($fields as $field) {
            $builder->withRelation($field);
        }
        $this->assertEquals(['vacancy', 'interview'], $builder->getRequest()->getQueryParams()['with']);
    }

    public function testFilter(): void
    {
        $vacancyId = 321;
        $responseId = 313;
        $request = (new ApiRequestBuilder())
            ->filter('vacancy_id', $vacancyId)
            ->filter('response_id', $responseId)
            ->getRequest();
        $filter = $request->getQueryParams()['filter'];
        $this->assertCount(2, $filter);
        $this->assertEquals($filter['vacancy_id'], $vacancyId);
        $this->assertEquals($filter['response_id'], $responseId);
    }

    public function testFilterMethods(): void
    {
        $id = 321;
        $active = true;
        $responseId = 8753;
        $vacancyId = 5123;
        $userId = 5124;
        $statusId = 8762;
        $email = 'test@example.com';
        $title = 'test resource title';
        $request = (new ApiRequestBuilder())
            ->whereId($id)
            ->whereActive($active)
            ->whereResponseId($responseId)
            ->whereVacancyId($vacancyId)
            ->whereUserId($userId)
            ->whereResponseStatusId($statusId)
            ->whereEmail($email)
            ->whereTitle($title)
            ->getRequest();

        $filter = $request->getQueryParams()['filter'];
        $this->assertCount(8, $filter);
        $this->assertEquals($filter['vacancy_id'], $vacancyId);
        $this->assertEquals($filter['response_id'], $responseId);
        $this->assertEquals($filter['id'], $id);
        $this->assertEquals($filter['active'], $active);
        $this->assertEquals($filter['user_id'], $userId);
        $this->assertEquals($filter['response_status_id'], $statusId);
        $this->assertEquals($filter['email'], $email);
        $this->assertEquals($filter['title'], $title);
    }

    public function testRelationMethods(): void
    {
        $relations = [
            'user', 'vacancy', 'response', 'candidate', 'attribute', 'interview', 'invite'
        ];
        $request = (new ApiRequestBuilder())
            ->withUser()
            ->withVacancy()
            ->withResponse()
            ->withCandidate()
            ->withAttribute()
            ->withInterview()
            ->withInvite()
            ->getRequest();

        $with = $request->getQueryParams()['with'];
        $this->assertCount(7, $with);
        foreach ($relations as $relation) {
            $this->assertContains($relation, $with);
        }
    }

    public function testNotUniqueRelationMethods(): void
    {
        $relations = ['user', 'response'];
        $request = (new ApiRequestBuilder())
            ->withUser()
            ->withUser()
            ->withResponse()
            ->withUser()
            ->getRequest();

        $with = $request->getQueryParams()['with'];
        $this->assertCount(2, $with);
        foreach ($relations as $relation) {
            $this->assertContains($relation, $with);
        }
    }
}