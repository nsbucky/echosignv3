<?php
namespace Echosign\Interfaces;

use Echosign\Abstracts\HttpRequest;

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