<?php
namespace Echosign\RequestBuilders;

use Echosign\Interfaces\RequestBuilder;
use Echosign\RequestBuilders\Agreement\InteractiveOptions;
use Echosign\RequestBuilders\LibraryDocument\LibraryDocumentCreationInfo;

/**
 * Class LibraryCreationInfo
 * @package Echosign\RequestBuilders
 */
class LibraryCreationInfo implements RequestBuilder
{
    /**
     * @var LibraryDocumentCreationInfo
     */
    protected $libraryDocumentCreationInfo;

    /**
     * @var InteractiveOptions
     */
    protected $interactiveOptions;

    public function __construct( LibraryDocumentCreationInfo $documentCreationInfo, InteractiveOptions $options )
    {
        $this->libraryDocumentCreationInfo = $documentCreationInfo;
        $this->interactiveOptions          = $options;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'libraryDocumentCreationInfo' => $this->libraryDocumentCreationInfo->toArray(),
            'options'                     => $this->interactiveOptions->toArray(),
        ];
    }
}