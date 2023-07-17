<?php

declare(strict_types=1);

namespace VcvApi\Tests;


use PHPUnit\Framework\TestCase;
use VcvApi\Api;
use VcvApi\Exception\ErrorException;
use VcvApi\Resources\Candidate\Invites;
use VcvApi\Resources\Candidate\ResponseAttributes;
use VcvApi\Resources\Candidate\ResponseAttributeValues;
use VcvApi\Resources\Candidate\ResponseComments;
use VcvApi\Resources\Candidate\Responses;
use VcvApi\Resources\Candidate\ResponseStatuses;
use VcvApi\Resources\Candidate\ResponseSurveys;
use VcvApi\Resources\Candidate\ResponseTags;
use VcvApi\Resources\Candidate\ResponseTests;
use VcvApi\Resources\Candidate\ResponseVideointerviews;
use VcvApi\Resources\Candidate\Tags;
use VcvApi\Resources\CompetenceLevels;
use VcvApi\Resources\CompetenceViews;
use VcvApi\Resources\Countries;
use VcvApi\Resources\Languages;
use VcvApi\Resources\Recruiter\Integrations;
use VcvApi\Resources\Recruiter\Vacancies;
use VcvApi\Resources\Recruiter\VacancyCompetences;
use VcvApi\Resources\Recruiter\VacancyPermissions;
use VcvApi\Resources\Recruiter\VacancySurveys;
use VcvApi\Resources\Recruiter\VacancyTests;
use VcvApi\Resources\Recruiter\VacancyVideointerviews;
use VcvApi\Resources\Users;
use VcvApi\Resources\Webhooks;

class ApiTest extends TestCase
{

    public function testCreateApi(): void
    {
        $api = new Api('');
        $this->assertInstanceOf(Api::class, $api);
    }

    public function testCreateResources(): void
    {
        $api = new Api('');
        $this->assertInstanceOf(Webhooks::class, $api->webhooks);
        $this->assertInstanceOf(Languages::class, $api->languages);
        $this->assertInstanceOf(Countries::class, $api->countries);
        $this->assertInstanceOf(CompetenceViews::class, $api->competenceViews);
        $this->assertInstanceOf(CompetenceLevels::class, $api->competenceLevels);
        $this->assertInstanceOf(Integrations::class, $api->integrations);
        $this->assertInstanceOf(Vacancies::class, $api->vacancies);
        $this->assertInstanceOf(VacancyCompetences::class, $api->vacancyCompetences);
        $this->assertInstanceOf(VacancyPermissions::class, $api->vacancyPermissions);
        $this->assertInstanceOf(VacancySurveys::class, $api->vacancySurveys);
        $this->assertInstanceOf(VacancyTests::class, $api->vacancyTests);
        $this->assertInstanceOf(VacancyVideointerviews::class, $api->vacancyVideointerviews);
        $this->assertInstanceOf(Invites::class, $api->invites);
        $this->assertInstanceOf(ResponseAttributes::class, $api->responseAttributes);
        $this->assertInstanceOf(ResponseAttributeValues::class, $api->responseAttributeValues);
        $this->assertInstanceOf(ResponseComments::class, $api->responseComments);
        $this->assertInstanceOf(Responses::class, $api->responses);
        $this->assertInstanceOf(ResponseStatuses::class, $api->responseStatuses);
        $this->assertInstanceOf(ResponseSurveys::class, $api->responseSurveys);
        $this->assertInstanceOf(ResponseTags::class, $api->responseTags);
        $this->assertInstanceOf(ResponseTests::class, $api->responseTests);
        $this->assertInstanceOf(ResponseVideointerviews::class, $api->responseVideointerviews);
        $this->assertInstanceOf(Tags::class, $api->tags);
        $this->assertInstanceOf(Users::class, $api->users);
    }

    public function testCreateInvalidResource(): void
    {
        $api = new Api('');
        $this->expectException(ErrorException::class);
        $api->invalidApi;
    }
}