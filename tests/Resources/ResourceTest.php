<?php

declare(strict_types=1);

namespace VcvApi\Tests\Resources;


use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use VcvApi\Http\Client;
use VcvApi\Request\ApiRequest;

class ResourceTest extends TestCase
{

    /**
     * @var MockObject|Client
     */
    private MockObject $httpClient;

    /**
     * @var FakeResource
     */
    private FakeResource $resource;

    public function setUp(): void
    {
        $this->httpClient = $this->createMock(Client::class);
        $this->resource = new FakeResource($this->httpClient);
    }

    public function testGetResourceById(): void
    {
        $expectedArray = ['id' => 123, 'fake' => 'field'];
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo(FakeResource::RESOURCE_NAME . '/' . (string)$expectedArray['id']),
                $this->equalTo([])
            )
            ->willReturn($expectedArray);
        $this->assertEquals($expectedArray, $this->resource->getById($expectedArray['id']));
    }

    public function testListResource(): void
    {
        $expectedArray = ['id' => 123, 'fake' => 'field'];
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo(FakeResource::RESOURCE_NAME),
                $this->equalTo([])
            )
            ->willReturn($expectedArray);
        $this->assertEquals($expectedArray, $this->resource->list());
    }

    public function testDeleteResource(): void
    {
        $expectedArray = ['id' => 123, 'fake' => 'field'];
        $this->httpClient->expects($this->once())
            ->method('delete')
            ->with(
                $this->equalTo(FakeResource::RESOURCE_NAME . '/' . (string)$expectedArray['id']),
                $this->equalTo([])
            )
            ->willReturn($expectedArray);
        $this->assertEquals($expectedArray, $this->resource->delete($expectedArray['id']));
    }

    public function testUpdateResource(): void
    {
        $expectedArray = ['id' => 123, 'fake' => 'field'];
        $this->httpClient->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo(FakeResource::RESOURCE_NAME . '/' . (string)$expectedArray['id']),
                $this->equalTo($expectedArray)
            )
            ->willReturn($expectedArray);
        $this->assertEquals($expectedArray, $this->resource->update($expectedArray['id'], $expectedArray));
    }

    public function testCreateResource(): void
    {
        $expectedArray = ['id' => 123, 'fake' => 'field'];
        $this->httpClient->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo(FakeResource::RESOURCE_NAME),
                $this->equalTo($expectedArray)
            )
            ->willReturn($expectedArray);
        $this->assertEquals($expectedArray, $this->resource->create($expectedArray));
    }
}