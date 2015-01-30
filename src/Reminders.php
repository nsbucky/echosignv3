<?php
namespace Echosign;

use Echosign\Abstracts\Resource;
use Echosign\RequestBuilders\ReminderCreationInfo;
use Echosign\Responses\ReminderCreationResult;

/**
 * Class Reminders
 * @package Echosign
 */
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
        $response = $this->simplePostRequest( $reminderCreationInfo->toArray() );

        return new ReminderCreationResult( $response );
    }
}