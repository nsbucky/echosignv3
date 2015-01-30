<?php

use Echosign\RequestBuilders\Agreement\FileInfo;
use Echosign\RequestBuilders\Agreement\DocumentCreationInfo;

class DocumentCreationInfoTest extends PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $fileInfo = new FileInfo();
        $fileInfo->setDocumentURL('test.pdf','http://www.yahoo.com','application/pdf');

        $doc = new DocumentCreationInfo( $fileInfo, 'test', 'ESIGN', 'SENDER_SIGNATURE_NOT_REQUIRED' );
        $doc->setCallBackInfo('http://localhost');

        $output = $doc->toArray();

        $this->assertEquals('test', $output['name']);
        $this->assertEquals('http://localhost', $output['callbackInfo']);

        $this->assertEquals(1, count( $output['fileInfos'] ) );

    }
}