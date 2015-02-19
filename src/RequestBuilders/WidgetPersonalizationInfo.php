<?php
namespace Echosign\RequestBuilders;

use Echosign\Interfaces\RequestBuilder;
use Echosign\Util;

/**
 * Class WidgetPersonalizationInfo
 * @package Echosign\RequestBuilders
 */
class WidgetPersonalizationInfo implements RequestBuilder
{
    protected $expiration;
    protected $email;

    /**
     * @var bool
     */
    protected $reusable;

    /**
     * @var bool
     */
    protected $allowManualVerification;
    protected $comment;

    /**
     * @param $email
     * @param string $comment
     */
    public function __construct( $email, $comment = null )
    {
        $this->email   = filter_var( $email, FILTER_SANITIZE_EMAIL );
        $this->comment = $comment;
    }

    /**
     * @return bool
     */
    public function isAllowManualVerification()
    {
        return $this->allowManualVerification;
    }

    /**
     * @param $allowManualVerification
     * @return $this
     */
    public function setAllowManualVerification( $allowManualVerification )
    {
        $this->allowManualVerification = (bool) $allowManualVerification;
        return $this;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @return $this
     */
    public function setComment( $comment )
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail( $email )
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @param \DateTime $expiration
     * @return $this
     */
    public function setExpiration( \DateTime $expiration )
    {
        $this->expiration = $expiration;
        return $this;
    }

    /**
     * @return bool
     */
    public function isReusable()
    {
        return (bool) $this->reusable;
    }

    /**
     * @param $reusable
     * @return $this
     */
    public function setReusable( $reusable )
    {
        $this->reusable = (bool) $reusable;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [
            'email'                   => $this->getEmail(),
            'reusable'                => $this->isReusable(),
            'allowManualVerification' => $this->isAllowManualVerification(),
            'comment'                 => $this->getComment(),
        ];

        if ($this->expiration) {
            $data['expiration'] = Util::api_date_format( $this->getExpiration() );
        }

        return $data;
    }
}