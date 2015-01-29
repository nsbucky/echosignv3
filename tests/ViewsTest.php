<?php

use Echosign\Views;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use Echosign\RequestBuilders\AgreementAssetRequest;
use Echosign\RequestBuilders\AgreementAssetListRequest;
use Echosign\RequestBuilders\TargetViewRequest;

class ViewsTest extends PHPUnit_Framework_TestCase
{
    protected $views;

    protected function initViews()
    {
        $transport = new \Echosign\Transports\GuzzleTransport();
        $client = $transport->getClient();
        $json = '{"viewUrl":"http://localhost"}';

        $stream = Stream::factory($json);

        $mock = new Mock([
            new Response(200, ['content-type'=>'application/json'], $stream)
        ]);

        $client->getEmitter()->attach($mock);

        $this->views = new Views('465789', $transport);
        return $this->views;
    }

    public function testAgreementAssets()
    {
        $views = $this->initViews();

        $assetRequest = new AgreementAssetRequest('123456');
        $response = $views->agreementAssets( $assetRequest );

        $this->assertInstanceOf('Echosign\Responses\ViewUrl', $response);
        $this->assertEquals('http://localhost', $response->getViewUrl());
    }

    public function testAgreementAssetList()
    {
        $views = $this->initViews();

        $assetRequest = new AgreementAssetListRequest('123456');
        $response = $views->agreementAssetList( $assetRequest );

        $this->assertInstanceOf('Echosign\Responses\ViewUrl', $response);
        $this->assertEquals('http://localhost', $response->getViewUrl());
    }

    public function testSettings()
    {
        $views = $this->initViews();

        $assetRequest = new TargetViewRequest('123456');
        $response = $views->settings( $assetRequest );

        $this->assertInstanceOf('Echosign\Responses\ViewUrl', $response);
        $this->assertEquals('http://localhost', $response->getViewUrl());
    }
}