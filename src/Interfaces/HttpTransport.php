<?php
namespace Echosign\Interfaces;

use Echosign\Abstracts\HttpRequest;

/**
 * Interface HttpTransport
 * @package Echosign\Interfaces
 */
interface HttpTransport
{
    /**
     * @param HttpRequest $httpRequest
     * @return mixed
     */
    public function handleRequest( HttpRequest $httpRequest );

    /**
     * @param $response
     * @return mixed
     */
    public function handleResponse( $response );

}