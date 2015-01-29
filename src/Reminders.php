<?php
namespace Echosign;

use Echosign\Abstracts\Resource;
use Echosign\RequestBuilders\ReminderCreationInfo;
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

    }
}