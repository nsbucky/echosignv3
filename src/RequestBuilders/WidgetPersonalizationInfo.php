<?php
namespace Echosign\RequestBuilders;

use Echosign\Interfaces\RequestBuilder;

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
     * @param bool $allowManualVerification
     */
    public function setAllowManualVerification( $allowManualVerification )
    {
        $this->allowManualVerification = (bool) $allowManualVerification;
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
     */
    public function setComment( $comment )
    {
        $this->comment = $comment;
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
     */
    public function setEmail( $email )
    {
        $this->email = $email;
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
     */
    public function setExpiration( \DateTime $expiration )
    {
        $this->expiration = $expiration;
    }

    /**
     * @return bool
     */
    public function isReusable()
    {
        return (bool) $this->reusable;
    }

    /**
     * @param bool $reusable
     */
    public function setReusable( $reusable )
    {
        $this->reusable = (bool) $reusable;
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
            $data['expiration'] = api_date_format( $this->getExpiration() );
        }

        return $data;
    }
}