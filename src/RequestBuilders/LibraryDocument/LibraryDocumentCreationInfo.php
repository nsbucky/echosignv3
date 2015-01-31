<?php
namespace Echosign\RequestBuilders\LibraryDocument;

use Echosign\Interfaces\RequestBuilder;
use Echosign\RequestBuilders\Agreement\FileInfo;

/**
 * Class LibraryDocumentCreationInfo
 * @package Echosign\RequestBuilders\LibraryDocument
 */
class LibraryDocumentCreationInfo implements RequestBuilder
{
    protected $libraryTemplateTypes = [ ];
    protected $fileInfos = [ ];
    protected $name;
    protected $librarySharingMode;

    /**
     * @param $name
     * @param $libraryTemplateType
     * @param FileInfo $fileInfo
     */
    public function __construct( $name, $libraryTemplateType, FileInfo $fileInfo, $librarySharingMode )
    {
        $this->name = $name;
        $this->setLibraryTemplateTypes( [ $libraryTemplateType ] );
        $this->addFileInfo( $fileInfo );
        $this->setLibrarySharingMode( $librarySharingMode );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [
            'name'                 => $this->name,
            'librarySharingMode'   => $this->librarySharingMode,
            'libraryTemplateTypes' => $this->getLibraryTemplateTypes(),
        ];

        if (count( $this->fileInfos )) {
            $data['fileInfos'] = [ ];
            foreach ($this->fileInfos as $t) {
                $data['fileInfos'][] = $t->toArray();
            }
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getLibraryTemplateTypes()
    {
        return $this->libraryTemplateTypes;
    }

    /**
     * @param array $libraryTemplateTypes
     */
    public function setLibraryTemplateTypes( array $libraryTemplateTypes )
    {
        $this->libraryTemplateTypes = $libraryTemplateTypes;
    }

    /**
     * @param $type
     */
    public function addLibraryTemplateType( $type )
    {
        if (!in_array( $type, [ 'DOCUMENT', 'FORM_FIELD_LAYER' ] )) {
            throw new \InvalidArgumentException( 'Invalid libraryTemplateType' );
        }

        $this->libraryTemplateTypes[] = $type;
    }

    /**
     * @return FileInfo[]
     */
    public function getFileInfos()
    {
        return $this->fileInfos;
    }

    /**
     * @param FileInfo []
     */
    public function setFileInfos( array $fileInfos )
    {
        $this->fileInfos = $fileInfos;
    }

    /**
     * @param FileInfo $fileInfo
     */
    public function addFileInfo( FileInfo $fileInfo )
    {
        $this->fileInfos[] = $fileInfo;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName( $name )
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLibrarySharingMode()
    {
        return $this->librarySharingMode;
    }

    /**
     * @param string $librarySharingMode
     */
    public function setLibrarySharingMode( $librarySharingMode )
    {
        if (!in_array( $librarySharingMode, [ 'GROUP', 'ACCOUNT', 'USER' ] )) {
            throw new \InvalidArgumentException( 'Invalid librarySharingMode' );
        }

        $this->librarySharingMode = $librarySharingMode;
    }


}