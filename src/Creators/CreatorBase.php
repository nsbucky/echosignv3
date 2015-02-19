<?php
namespace Echosign\Creators;

use Echosign\Interfaces\HttpTransport;
use Echosign\Transports\GuzzleTransport;

class CreatorBase
{
    /**
     * @var string
     */
    protected $token;

    /**
     * @var HttpTransport
     */
    protected $transport;

    /**
     * @var array
     */
    protected $errorMessages = [];

    /**
     * @var mixed
     */
    protected $response;

    /**
     * @param $token
     * @param HttpTransport $transport
     * @param array $transportOptions
     */
    public function __construct( $token, HttpTransport $transport = null, array $transportOptions = [] )
    {
        $this->token = $token;

        if( $transport !== null ) {
            $this->transport = $transport;
            return;
        }

        $this->transport = new GuzzleTransport( $transportOptions );
    }

    /**
     * @param HttpTransport $transport
     * @return $this
     */
    public function setTransport( HttpTransport $transport )
    {
        $this->transport = $transport;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setToken( $token )
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return HttpTransport
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * @return array
     */
    public function getErrorMessages()
    {
        return array_filter($this->errorMessages);
    }

    /**
     * @return bool
     */
    public function hasErrors()
    {
        return (bool) count( $this->errorMessages );
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

}