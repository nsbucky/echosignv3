<?php
namespace Echosign\RequestBuilders;

use Echosign\Interfaces\RequestBuilder;
use Echosign\RequestBuilders\Agreement\DocumentCreationInfo;
use Echosign\RequestBuilders\Agreement\InteractiveOptions;

class AgreementCreationInfo implements  RequestBuilder
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
     * @param mixed $documentCreationInfo
     */
    public function setDocumentCreationInfo( $documentCreationInfo )
    {
        $this->documentCreationInfo = $documentCreationInfo;
    }

    /**
     * @return mixed
     */
    public function getInteractiveOptions()
    {
        return $this->interactiveOptions;
    }

    /**
     * @param mixed $options
     */
    public function setInteractiveOptions( $options )
    {
        $this->interactiveOptions = $options;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'documentCreationInfo' => $this->documentCreationInfo->toArray(),
            'options' => $this->interactiveOptions->toArray()
        ];
    }
}