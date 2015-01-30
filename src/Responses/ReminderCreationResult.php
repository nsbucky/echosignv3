<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;

/**
 * Class ReminderCreationResult
 * @package Echosign\Responses
 */
class ReminderCreationResult implements ApiResponse
{
    /**
     * @var string
     */
    protected $result;

    /**
     * @var string
     */
    protected $recipientEmail;

    /**
     * @var array
     */
    protected $response;

    /**
     * @param array $response
     */
    public function __construct( array $response )
    {
        $this->response       = $response;
        $this->result         = array_get( $response, 'result' );
        $this->recipientEmail = array_get( $response, 'recipientEmail' );
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return string
     */
    public function getRecipientEmail()
    {
        return $this->recipientEmail;
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

}