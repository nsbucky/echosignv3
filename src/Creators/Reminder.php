<?php
namespace Echosign\Creators;

use Echosign\Exceptions\JsonApiResponseException;
use Echosign\Reminders;
use Echosign\RequestBuilders\ReminderCreationInfo;

class Reminder extends CreatorBase
{
    /**
     * @var Reminders
     */
    protected $reminder;

    /**
     * Create a reminder for an outstanding agreement.
     * @param $agreementId
     * @param null $message
     * @return bool|string
     */
    public function create( $agreementId, $message = null )
    {
        $this->reminder       = new Reminders( $this->getToken(), $this->getTransport() );
        $reminderCreationInfo = new ReminderCreationInfo( $agreementId, $message );

        try {
            $this->response = $this->reminder->create( $reminderCreationInfo );
        } catch ( JsonApiResponseException $e ) {
            $this->errorMessages[ $e->getCode() ] = sprintf( '%s - %s', $e->getApiCode(), $e->getMessage() );
            return false;
        } catch ( \Exception $e ) {
            $this->errorMessages[ $e->getCode() ] = $e->getMessage();
            return false;
        }

        return $this->response->getResult();
    }

    /**
     * @return Reminders
     */
    public function getReminder()
    {
        return $this->reminder;
    }

}