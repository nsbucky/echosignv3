<?php

use Echosign\Reminders;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use Echosign\RequestBuilders\ReminderCreationInfo;

class RemindersTest extends PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $returnJson = '{
              "result": "SUCCESS",
              "recipientEmail": "test@test.com"
        }';

        $transport = new \Echosign\Transports\GuzzleTransport();
        $client = $transport->getClient();

        $stream = Stream::factory($returnJson);

        $mock = new Mock([
            new Response(200, ['content-type'=>'application/json'], $stream)
        ]);

        $client->getEmitter()->attach($mock);

        $reminder = new Reminders( '123456', $transport );

        $creationInfo = new ReminderCreationInfo('1234','have a great day');

        $response = $reminder->create( $creationInfo );

        $this->assertInstanceOf('Echosign\Responses\ReminderCreationResult', $response);

        $this->assertEquals('SUCCESS', $response->getResult() );
        $this->assertEquals('test@test.com', $response->getRecipientEmail());
    }
}