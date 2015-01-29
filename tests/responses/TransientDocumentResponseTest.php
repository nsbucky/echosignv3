<?php

use Echosign\Responses\TransientDocumentResponse;

class TransientDocumentResponseTest extends PHPUnit_Framework_TestCase
{
    public function testCreateDoc()
    {
        $response = [
            'transientDocumentId' => md5( time() )
        ];

        $tdr = new TransientDocumentResponse($response);

        $this->assertEquals( $response['transientDocumentId'], $tdr->getTransientDocumentId() );
    }
}