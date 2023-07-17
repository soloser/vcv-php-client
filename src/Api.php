<?php

declare(strict_types=1);

namespace VcvApi;

use VcvApi\Exception\ErrorException;
use VcvApi\Http\Client;
use VcvApi\Resources\AbstractResource;
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

/**
 * @property Webhooks $webhooks
 * @property Languages $languages
 * @property Countries $countries
 * @property CompetenceViews $competenceViews
 * @property CompetenceLevels $competenceLevels
 * @property Integrations $integrations
 * @property Vacancies $vacancies
 * @property VacancyCompetences $vacancyCompetences
 * @property VacancyPermissions $vacancyPermissions
 * @property VacancySurveys $vacancySurveys
 * @property VacancyTests $vacancyTests
 * @property VacancyVideointerviews $vacancyVideointerviews
 * @property Invites $invites
 * @property ResponseAttributes $responseAttributes
 * @property ResponseAttributeValues $responseAttributeValues
 * @property ResponseComments $responseComments
 * @property Responses $responses
 * @property ResponseStatuses $responseStatuses
 * @property ResponseSurveys $responseSurveys
 * @property ResponseTags $responseTags
 * @property ResponseTests $responseTests
 * @property ResponseVideointerviews $responseVideointerviews
 * @property Tags $tags
 * @property Users $users
 */
final class Api
{

    /**
     * Default base url
     * @var string
     */
    private const BASE_URL = 'https://my.vcv.ai/api/v3/';

    /**
     * The default user agent header.
     *
     * @var string
     */
    private const USER_AGENT = 'vcv-php-client/1.0';

    /**
     * @var Client
     */
    private Client $client;

    /**
     * @param string $apikey
     * @param string $host
     */
    public function __construct(string $apikey, string $host = self::BASE_URL)
    {
        $httpClient = new \GuzzleHttp\Client([
            'base_uri' => $host,
            'headers' => ['Authorization' => 'Bearer ' . $apikey, 'User-Agent' => self::USER_AGENT]
        ]);
        $this->client =  new Client($httpClient);
    }

    public static function getValidResources(): array
    {
        return [
            'webhooks' => Webhooks::class,
            'languages' => Languages::class,
            'countries' => Countries::class,
            'competenceViews' => CompetenceViews::class,
            'competenceLevels' => CompetenceLevels::class,
            'integrations' => Integrations::class,
            'vacancies' => Vacancies::class,
            'vacancyCompetences' => VacancyCompetences::class,
            'vacancyPermissions' => VacancyPermissions::class,
            'vacancySurveys' => VacancySurveys::class,
            'vacancyTests' => VacancyTests::class,
            'vacancyVideointerviews' => VacancyVideointerviews::class,
            'invites' => Invites::class,
            'responseAttributes' => ResponseAttributes::class,
            'responseAttributeValues' => ResponseAttributeValues::class,
            'responseComments' => ResponseComments::class,
            'responses' => Responses::class,
            'responseStatuses' => ResponseStatuses::class,
            'responseSurveys' => ResponseSurveys::class,
            'responseTags' => ResponseTags::class,
            'responseTests' => ResponseTests::class,
            'responseVideointerviews' => ResponseVideointerviews::class,
            'tags' => Tags::class,
            'users' => Users::class,
        ];
    }

    /**
     * @param string $property
     * @return AbstractResource
     * @throws ErrorException
     */
    public function __get(string $property): AbstractResource
    {
        if ((array_key_exists($property, $resources = $this::getValidResources()))) {
            $className = $resources[$property];
            $class = new $className($this->client);
        } else {
            throw new ErrorException("No property $property available in " . __CLASS__);
        }

        return $class;
    }
}
