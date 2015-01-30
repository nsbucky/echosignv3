<?php

class UserCreationInfoTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $info = new \Echosign\RequestBuilders\UserCreationInfo( 'Fred', 'Fonz', 'test@test.com', '123fart' );

        $output = $info->toArray();
        $this->assertEquals( 'Fred', $output['firstName'] );
        $this->assertEquals( 'Fonz', $output['lastName'] );
        $this->assertEquals( 'test@test.com', $output['email'] );
        $this->assertEquals( '123fart', $output['password'] );
    }
}