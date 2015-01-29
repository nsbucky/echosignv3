<?php
namespace Echosign;

use Echosign\Abstracts\Resource;
use Echosign\Requests\GetRequest;
use Echosign\Responses\BaseUriInfo;

/**
 * Class BaseUris
 * @package Echosign
 */
class BaseUris extends Resource
{
    protected $baseApiPath = 'base_uris';

    /**
     * @return BaseUriInfo
     * @throws \RuntimeException on bad response received
     */
    public function getBaseUris()
    {
        $request = new GetRequest( $this->getOAuthToken(), $this->getRequestUrl() );

        $transport = $this->getTransport();

        $this->setRequest( $request );
        $this->logDebug( "Creating GET request to ".$this->getRequestUrl() );

        $response = $transport->handleRequest( $request );

        if( ! is_array( $response ) ) {
            $this->responseReceived = $response;
            throw new \RuntimeException('Bad response received! Please inspect responseReceived');
        }

        $this->logDebug( "response", $response );

        return new BaseUriInfo( (array) $response );
    }

}