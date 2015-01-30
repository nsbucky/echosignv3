<?php
namespace Echosign\RequestBuilders;

use Echosign\Interfaces\RequestBuilder;

/**
 * Class AgreementStatusUpdateInfo
 * @package Echosign\RequestBuilders
 */
class AgreementStatusUpdateInfo implements RequestBuilder
{
    protected $value = 'CANCEL';
    protected $comment;
    protected $notifySigner = false;

    /**
     * @param string $comment
     * @param bool $notifySigner
     */
    public function __construct( $comment = null, $notifySigner = false )
    {
        $this->comment      = $comment;
        $this->notifySigner = $notifySigner;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'value'        => $this->value,
            'comment'      => $this->comment,
            'notifySigner' => $this->notifySigner
        ];
    }
}