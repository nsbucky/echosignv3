<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;

class WidgetInfo implements ApiResponse
{
    protected $message;
    protected $javascript;
    protected $securityOptions = [];
    protected $status;
    protected $events = [];
    protected $name;
    protected $locale;
    protected $widgetId;
    protected $participants = [];
    protected $latestVersionId;
    protected $url;

    /**
     * @var array
     */
    protected $response;

    public function __construct( array $response )
    {
        $this->response = $response;

        foreach( ['message','securityOptions', 'status', 'events', 'name', 'locale',
                  'widgetId', 'participants', 'latestVersionId' ,'javascript','url'] as $k ) {
            $this->$k = array_get( $response, $k );
        }
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getJavascript()
    {
        return $this->javascript;
    }

    /**
     * @return mixed
     */
    public function getWidgetId()
    {
        return $this->widgetId;
    }

    /**
     * @return array
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @return mixed
     */
    public function getLatestVersionId()
    {
        return $this->latestVersionId;
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @return array
     */
    public function getSecurityOptions()
    {
        return $this->securityOptions;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }
}