<?php
namespace Echosign\Creators;

use Echosign\Exceptions\JsonApiResponseException;
use Echosign\TransientDocuments;

class TransientDocument extends CreatorBase
{
    /**
     * @var TransientDocuments
     */
    protected $transientDocument;

    /**
     * create a transientDocument from a local file. If successful, it returns the transientDocumentId.
     * @param $filename
     * @param null $mimeType
     * @return bool|string
     */
    public function create( $filename, $mimeType = null )
    {
        $this->transientDocument = new TransientDocuments( $this->getToken(), $this->getTransport() );

        try {
            $this->response = $this->transientDocument->create( $filename, $mimeType );
        } catch ( JsonApiResponseException $e ) {
            $this->errorMessages[ $e->getCode() ] = sprintf( '%s - %s', $e->getApiCode(), $e->getMessage() );
            return false;
        } catch ( \Exception $e ) {
            $this->errorMessages[ $e->getCode() ] = $e->getMessage();
            return false;
        }

        return $this->response->getTransientDocumentId();
    }

    /**
     * @return mixed
     */
    public function getTransientDocument()
    {
        return $this->transientDocument;
    }

}