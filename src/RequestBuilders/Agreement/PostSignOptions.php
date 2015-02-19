<?php
namespace Echosign\RequestBuilders\Agreement;

use Echosign\Interfaces\RequestBuilder;

/**
 * Class PostSignOptions
 * @package Echosign\RequestBuilders\Agreement
 */
class PostSignOptions implements RequestBuilder
{
    /**
     * @var int
     */
    protected $redirectDelay = 0;

    /**
     * @var string
     */
    protected $redirectUrl;

    /**
     * @param $redirectUrl
     * @param int $redirectDelay
     */
    public function __construct( $redirectUrl, $redirectDelay = 0 )
    {
        $this->redirectUrl   = filter_var( $redirectUrl, FILTER_SANITIZE_URL );
        $this->redirectDelay = (int) $redirectDelay;
    }

    /**
     * @return int
     */
    public function getRedirectDelay()
    {
        return $this->redirectDelay;
    }

    /**
     * @param int $redirectDelay
     * @return $this
     */
    public function setRedirectDelay( $redirectDelay )
    {
        $this->redirectDelay = $redirectDelay;
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
     * @param string $redirectUrl
     * @return $this
     */
    public function setRedirectUrl( $redirectUrl )
    {
        $this->redirectUrl = $redirectUrl;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'redirectDelay' => $this->redirectDelay,
            'redirectUrl'   => $this->redirectUrl,
        ];
    }


}