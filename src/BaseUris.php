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
    /**
     * @return BaseUriInfo
     * @throws \RuntimeException on bad response received
     */
    public function getBaseUris()
    {
        $this->setApiRequestUrl( 'base_uris' );

        $request = new GetRequest( $this->getOAuthToken(), $this->getRequestUrl() );

        $transport = $this->getTransport();

        $response = $transport->handleRequest( $request );

        if( ! is_array( $response ) ) {
            $this->responseReceived = $response;
            throw new \RuntimeException('Bad response received! Please inspect responseReceived');
        }

        return new BaseUriInfo( (array) $response );
    }

}