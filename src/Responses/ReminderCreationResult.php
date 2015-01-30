<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;
use Echosign\Util;

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
        $this->result         = Util::array_get( $response, 'result' );
        $this->recipientEmail = Util::array_get( $response, 'recipientEmail' );
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