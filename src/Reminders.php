<?php
namespace Echosign;

use Echosign\Abstracts\Resource;
use Echosign\RequestBuilders\ReminderCreationInfo;
use Echosign\Requests\PostRequest;
use Echosign\Responses\ReminderCreationResult;

class Reminders extends Resource
{
    protected $baseApiPath = 'reminders';

    /**
     * Sends a reminder for an agreement
     * @param ReminderCreationInfo $reminderCreationInfo
     * @return ReminderCreationResult
     */
    public function create( ReminderCreationInfo $reminderCreationInfo )
    {
        $request = new PostRequest( $this->getOAuthToken(), $this->getRequestUrl() );

        $request->setBody( $reminderCreationInfo->toArray() );

        $transport = $this->getTransport();

        $this->setRequest( $request );
        $this->logDebug( "Creating POST request to ".$this->getRequestUrl() );

        $response = $transport->handleRequest( $request );

        if( ! is_array( $response ) ) {
            $this->responseReceived = $response;
            throw new \RuntimeException('Bad response received! Please inspect responseReceived');
        }

        $this->logDebug( "response", $response );

        return new ReminderCreationResult( $response );
    }
}