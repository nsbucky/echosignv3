<?php
namespace Echosign\RequestBuilders;

use Echosign\Interfaces\RequestBuilder;

/**
 * Class ReminderCreationInfo
 * @package Echosign\RequestBuilders
 */
class ReminderCreationInfo implements RequestBuilder
{
    /**
     * @var string
     */
    protected $agreementId;

    /**
     * @var string
     */
    protected $comment;

    /**
     * @param $agreementId
     * @param $comment
     */
    public function __construct( $agreementId, $comment = null )
    {
        $this->agreementId = $agreementId;
        $this->comment     = $comment;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'agreementId' => $this->agreementId,
            'comment'     => $this->comment,
        ];
    }
}