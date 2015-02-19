<?php
namespace Echosign\RequestBuilders;

use Echosign\Interfaces\RequestBuilder;
use Echosign\RequestBuilders\Agreement\DocumentCreationInfo;
use Echosign\RequestBuilders\Agreement\InteractiveOptions;

/**
 * Class AgreementCreationInfo
 * @package Echosign\RequestBuilders
 */
class AgreementCreationInfo implements RequestBuilder
{
    /**
     * @var DocumentCreationInfo
     */
    protected $documentCreationInfo;

    /**
     * @var InteractiveOptions
     */
    protected $interactiveOptions;

    /**
     * @param DocumentCreationInfo $documentCreationInfo
     * @param InteractiveOptions $interactiveOptions
     */
    public function __construct( DocumentCreationInfo $documentCreationInfo, InteractiveOptions $interactiveOptions )
    {
        $this->documentCreationInfo = $documentCreationInfo;
        $this->interactiveOptions   = $interactiveOptions;
    }

    /**
     * @return mixed
     */
    public function getDocumentCreationInfo()
    {
        return $this->documentCreationInfo;
    }

    /**
     * @param $documentCreationInfo
     * @return $this
     */
    public function setDocumentCreationInfo( $documentCreationInfo )
    {
        $this->documentCreationInfo = $documentCreationInfo;
        return $this;
    }

    /**
     * @return InteractiveOptions
     */
    public function getInteractiveOptions()
    {
        return $this->interactiveOptions;
    }

    /**
     * @param InteractiveOptions $options
     * @return $this
     */
    public function setInteractiveOptions( InteractiveOptions $options )
    {
        $this->interactiveOptions = $options;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'documentCreationInfo' => $this->documentCreationInfo->toArray(),
            'options'              => $this->interactiveOptions->toArray()
        ];
    }
}