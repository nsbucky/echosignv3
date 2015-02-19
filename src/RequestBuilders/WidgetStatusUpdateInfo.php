<?php
namespace Echosign\RequestBuilders;

use Echosign\Interfaces\RequestBuilder;

/**
 * Class WidgetStatusUpdateInfo
 * @package Echosign\RequestBuilders
 */
class WidgetStatusUpdateInfo implements RequestBuilder
{
    protected $message;
    protected $value;
    protected $redirectUrl;

    public function __construct( $value, $message, $redirectUrl )
    {
        $this->setValue( $value );
        $this->message = $message;
        $this->setRedirectUrl( $redirectUrl );
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param $message
     * @return $this
     */
    public function setMessage( $message )
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * @param $redirectUrl
     * @return $this
     */
    public function setRedirectUrl( $redirectUrl )
    {
        $this->redirectUrl = filter_var( $redirectUrl, FILTER_SANITIZE_URL );
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue( $value )
    {
        if (!in_array( $value, [ 'ENABLE', 'DISABLE' ] )) {
            throw new \InvalidArgumentException( 'Invalid value' );
        }
        $this->value = $value;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'message'     => $this->message,
            'value'       => $this->value,
            'redirectUrl' => $this->redirectUrl,
        ];
    }
}