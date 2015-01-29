<?php

use Echosign\Users;
use Echosign\RequestBuilders\UserCreationInfo;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;

class UsersTest extends PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $transport = new \Echosign\Transports\GuzzleTransport();
        $client = $transport->getClient();

        $json = '{"userId":"123446"}';

        $stream = Stream::factory($json);

        $mock = new Mock([
            new Response(200, ['content-type'=>'application/json'], $stream)
        ]);

        $client->getEmitter()->attach($mock);

        $users = new Users('465789', $transport);

        $creationInfo = new UserCreationInfo('Fred','Flintstone', 'fred@barney.com', '123rock');

        $response = $users->create( $creationInfo );

        $this->assertInstanceOf('Echosign\Responses\UserCreationResponse', $response);

        $this->assertEquals('123446', $response->getUserId() );
    }

    public function testListAll()
    {
        $transport = new \Echosign\Transports\GuzzleTransport();
        $client = $transport->getClient();

        $json = '{
          "userInfoList": [
            {
              "company": "My Company, LLC",
              "email": "kenrick@company.com",
              "fullNameOrEmail": "My Company",
              "groupId": "2BAABLblqZhAxtQfJjDmP2rfRiL_sT83WVNLSS_ZrcOw6UQNbfYYZn9HSluHuA1x63UT41eFNAYI*",
              "userId": "2ACABLblqZhAKeyuN406fXRj1LowesdnhuXS_c8mxjpby3X9p-NXY_NWXq4RAoMKWqVtElqjA5gk*"
            }
          ]
        }';

        $stream = Stream::factory($json);

        $mock = new Mock([
            new Response(200, ['content-type'=>'application/json'], $stream)
        ]);

        $client->getEmitter()->attach($mock);

        $users = new Users('465789', $transport);

        $response = $users->listAll();

        $this->assertInstanceOf('Echosign\Responses\UsersInfo', $response);

        $usersInfo = $response->getUserInfoList();

        $this->assertEquals(1, count( $usersInfo ) );

        $this->assertEquals('kenrick@company.com', $usersInfo[0]['email']);
    }

    public function testDetails()
    {
        $json = '{
          "account": "cperformance",
          "accountType": "GLOBAL",
          "capabilityFlags": [
            "CAN_SEND",
            "CAN_SIGN",
            "CAN_REPLACE_SIGNER"
          ],
          "channel": "_default",
          "company": "John Law Group",
          "email": "intake@contract.com",
          "firstName": "Bill",
          "initials": "NJ",
          "lastName": "John",
          "passwordExpiration": "2021-11-11T08:26:30-08:00"
        }';

        $transport = new \Echosign\Transports\GuzzleTransport();
        $client = $transport->getClient();

        $stream = Stream::factory($json);

        $mock = new Mock([
            new Response(200, ['content-type'=>'application/json'], $stream)
        ]);

        $client->getEmitter()->attach($mock);

        $users = new Users('465789', $transport);
        $response = $users->details('123456');

        $this->assertInstanceOf('Echosign\Responses\UserDetailsInfo', $response);

        $this->assertEquals('intake@contract.com', $response->getEmail());

        $capabilities = $response->getCapabilityFlags();

        $this->assertEquals(3, count( $capabilities ));
    }
}