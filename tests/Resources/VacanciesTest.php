<?php

declare(strict_types=1);

namespace VcvApi\Tests\Resources;


use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use VcvApi\Http\Client;
use VcvApi\Resources\Recruiter\Vacancies;

class VacanciesTest extends TestCase
{

    /**
     * @var MockObject|Client
     */
    private MockObject $httpClient;

    /**
     * @var Vacancies
     */
    private Vacancies $resource;

    public function setUp(): void
    {
        $this->httpClient = $this->createMock(Client::class);
        $this->resource = new Vacancies($this->httpClient);
    }

    public function testArchiveList(): void
    {
        $ids = [123, 456];
        $expectedArray = ['some' => 'field'];
        $expectedBody = [
            'vacancies' => [
                ['id' => 123, 'active' => false],
                ['id' => 456, 'active' => false],
            ]
        ];
        $this->httpClient->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('vacancies'),
                $this->equalTo($expectedBody)
            )
            ->willReturn($expectedArray);
        $this->assertEquals($expectedArray, $this->resource->archiveList($ids));
    }

    public function testArchiveIncorrectIds(): void
    {
        $ids = ['ids' => [123, 456]];
        $this->expectException(\TypeError::class);
        $this->resource->archiveList($ids);
    }

    public function testRestoreList(): void
    {
        $ids = [123, 456];
        $expectedArray = ['some' => 'field'];
        $expectedBody = [
            'vacancies' => [
                ['id' => 123, 'active' => true],
                ['id' => 456, 'active' => true],
            ]
        ];
        $this->httpClient->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('vacancies'),
                $this->equalTo($expectedBody)
            )
            ->willReturn($expectedArray);
        $this->assertEquals($expectedArray, $this->resource->restoreList($ids));
    }

    public function testRestoreIncorrectIds(): void
    {
        $ids = ['some' => 'field'];
        $this->expectException(\TypeError::class);
        $this->resource->restoreList($ids);
    }

    public function testDeleteList(): void
    {
        $ids = [123, 456];
        $expectedArray = ['some' => 'field'];
        $expectedBody = [
            'vacancies' => [
                ['id' => 123],
                ['id' => 456],
            ]
        ];
        $this->httpClient->expects($this->once())
            ->method('delete')
            ->with(
                $this->equalTo('vacancies'),
                $this->equalTo([]),
                $this->equalTo($expectedBody)
            )
            ->willReturn($expectedArray);
        $this->assertEquals($expectedArray, $this->resource->deleteList($ids));
    }

    public function testDeleteIncorrectIds(): void
    {
        $ids = ['some' => 'field'];
        $this->expectException(\TypeError::class);
        $this->resource->deleteList($ids);
    }
}