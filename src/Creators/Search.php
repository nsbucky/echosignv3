<?php
namespace Echosign\Creators;

use Echosign\Exceptions\JsonApiResponseException;
use Echosign\RequestBuilders\AgreementAssetEventRequest;
use Echosign\Search as SearchRequest;

class Search extends CreatorBase
{
    /**
     * @var SearchRequest
     */
    protected $search;

    /**
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param null $userId
     * @param null $userEmail
     * @return array|bool
     */
    public function create( \DateTime $startDate, \DateTime $endDate, $userId = null, $userEmail = null)
    {
        $this->search = new SearchRequest( $this->getToken(), $this->getTransport() );
        $eventRequest = new AgreementAssetEventRequest( $startDate, $endDate );

        try {
            $this->response = $this->search->create( $eventRequest, $userId, $userEmail );
        } catch ( JsonApiResponseException $e ) {
            $this->errorMessages[ $e->getCode() ] = sprintf( '%s - %s', $e->getApiCode(), $e->getMessage() );
            return false;
        } catch ( \Exception $e ) {
            $this->errorMessages[ $e->getCode() ] = $e->getMessage();
            return false;
        }

        return $this->response->getEvents();
    }

    /**
     * @param $searchId
     * @param $pageCursor
     * @param null $userId
     * @param null $userEmail
     * @return array|bool
     */
    public function result($searchId, $pageCursor, $userId = null, $userEmail = null)
    {
        try {
            $this->response = $this->search->result( $searchId, $pageCursor, $userId, $userEmail );
        } catch ( JsonApiResponseException $e ) {
            $this->errorMessages[ $e->getCode() ] = sprintf( '%s - %s', $e->getApiCode(), $e->getMessage() );
            return false;
        } catch ( \Exception $e ) {
            $this->errorMessages[ $e->getCode() ] = $e->getMessage();
            return false;
        }

        return $this->response->getEvents();
    }
}