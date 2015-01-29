<?php
namespace Echosign;

use Echosign\Abstracts\Resource;
use Echosign\Requests\PostRequest;
use Echosign\Responses\TransientDocumentResponse;

/**
 * Class TransientDocuments
 * @package Echosign
 */
class TransientDocuments extends Resource
{
    protected $baseApiPath = 'transientDocuments';
    protected $pathToFile;
    protected $fileName;
    protected $mimeType;

    /**
     * @param $pathToFile
     * @param null $mimeType
     * @return TransientDocumentResponse
     */
    public function create( $pathToFile, $mimeType = null )
    {
        if( ! file_exists( $pathToFile ) ) {
            throw new \RuntimeException("$pathToFile does not exist");
        }

        $this->pathToFile = $pathToFile;
        $this->fileName   = basename( $pathToFile );
        $this->mimeType   = $this->detectMimeType( $pathToFile, $mimeType );

        $request = new PostRequest( $this->getOAuthToken(), $this->getRequestUrl() );
        $request->setJsonRequest( false );
        $request->setBody([
            'File-Name'    => $this->fileName,
            'Mime-Type'    => $this->mimeType,
            'File'         => fopen($this->pathToFile, 'r')
        ]);

        $this->setRequest( $request );
        $this->logDebug("Creating POST request to ".$this->getRequestUrl(), [$this->pathToFile, $this->mimeType] );

        $transport = $this->getTransport();
        $response  = $transport->handleRequest( $request );

        if( ! is_array( $response ) ) {
            $this->responseReceived = $response;
            throw new \RuntimeException('Bad response received! Please inspect responseReceived');
        }

        $this->logDebug("response", $response);

        return new TransientDocumentResponse( $response );
    }

    /**
     * @param $file
     * @param $defaultMimeType
     * @return mixed
     */
    protected function detectMimeType( $file, $defaultMimeType )
    {
        if( function_exists('finfo_open') ) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $type = finfo_file( $finfo, $file );
            finfo_close($finfo);
            return $type;
        }

        return $defaultMimeType;
    }
}