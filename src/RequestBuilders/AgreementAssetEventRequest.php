<?php
namespace Echosign\RequestBuilders;

use Echosign\Interfaces\RequestBuilder;
use Echosign\Util;

/**
 * Class AgreementAssetEventRequest
 * @package Echosign\RequestBuilders
 */
class AgreementAssetEventRequest implements RequestBuilder
{
    /**
     * @var \DateTime
     */
    protected $startDate;

    /**
     * @var \DateTime
     */
    protected $endDate;

    /**
     * @var int
     */
    protected $pageSize = 100;

    /**
     * @var bool
     */
    protected $onlyShowLatestEvent = false;

    /**
     * @var array
     */
    protected $filterEvents = [ ];

    /**
     * allowed filter events
     * @var array
     */
    protected $allowedEvents = [
        "SHARED",
        "DOCUMENTS_DELETED",
        "SIGNER_SUGGESTED_CHANGES",
        "EMAIL_BOUNCED",
        "SIGNED",
        "OTHER",
        "APPROVED",
        "EXPIRED_AUTOMATICALLY",
        "VAULTED",
        "PRESIGNED",
        "APPROVAL_REQUESTED",
        "ESIGNED",
        "DELEGATED",
        "AUTO_CANCELLED_CONVERSION_PROBLEM",
        "FAXED_BY_SENDER",
        "PASSWORD_AUTHENTICATION_FAILED",
        "DIGSIGNED",
        "KBA_AUTHENTICATED",
        "SIGNATURE_REQUESTED",
        "EXPIRED",
        "REJECTED",
        "WEB_IDENTITY_AUTHENTICATED",
        "UPLOADED_BY_SENDER",
        "WEB_IDENTITY_SPECIFIED",
        "WIDGET_DISABLED",
        "CREATED",
        "OFFLINE_SYNC",
        "AUTO_DELEGATED",
        "REPLACED_SIGNER",
        "WIDGET_ENABLED",
        "EMAIL_VIEWED",
        "RECALLED",
        "FAXIN_RECEIVED",
        "SENDER_CREATED_NEW_REVISION",
        "KBA_AUTHENTICATION_FAILED"
    ];

    /**
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param int $pageSize
     * @param bool $onlyShowLatestEvent
     */
    public function __construct(
        \DateTime $startDate,
        \DateTime $endDate,
        $pageSize = 100,
        $onlyShowLatestEvent = false
    ) {
        $this->startDate           = $startDate;
        $this->endDate             = $endDate;
        $this->pageSize            = $pageSize;
        $this->onlyShowLatestEvent = $onlyShowLatestEvent;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate( \DateTime $endDate )
    {
        $this->endDate = $endDate;
    }

    /**
     * @return array
     */
    public function getFilterEvents()
    {
        return $this->filterEvents;
    }

    /**
     * @param array $filterEvents
     */
    public function setFilterEvents( array $filterEvents )
    {
        $this->filterEvents = $filterEvents;
    }

    /**
     * @param $event
     */
    public function addFilterEvent( $event )
    {
        if (!in_array( $event, $this->allowedEvents )) {
            return;
        }

        $this->filterEvents[] = $event;
    }

    /**
     * @return boolean
     */
    public function isOnlyShowLatestEvent()
    {
        return $this->onlyShowLatestEvent;
    }

    /**
     * @param boolean $onlyShowLatestEvent
     */
    public function setOnlyShowLatestEvent( $onlyShowLatestEvent )
    {
        $this->onlyShowLatestEvent = (bool) $onlyShowLatestEvent;
    }

    /**
     * @return int
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * @param int $pageSize
     */
    public function setPageSize( $pageSize )
    {
        $this->pageSize = (int) $pageSize;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate( \DateTime $startDate )
    {
        $this->startDate = $startDate;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [
            'startDate'           => Util::api_date_format( $this->startDate ),
            'endDate'             => Util::api_date_format( $this->endDate ),
            'pageSize'            => $this->getPageSize(),
            'onlyShowLatestEvent' => $this->isOnlyShowLatestEvent(),
        ];

        if (count( $this->filterEvents ) > 0) {
            $data['filterEvents'] = array_unique( $this->filterEvents );
        }

        return $data;
    }
}