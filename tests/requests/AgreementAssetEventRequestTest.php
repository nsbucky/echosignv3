<?php
use Echosign\RequestBuilders\AgreementAssetEventRequest;

class AgreementAssetEventRequestTest extends PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $startDate = new DateTime();
        $endDate   = new DateTime();

        $request = new AgreementAssetEventRequest( $startDate, $endDate, 2, true );

        $request->addFilterEvent( 'SHARED' );
        $request->addFilterEvent( 'FAXED_BY_SENDER' );

        $output = $request->toArray();

        $this->assertEquals( api_date_format( $startDate ), $output['startDate'] );
        $this->assertEquals( api_date_format( $startDate ), $output['endDate'] );
        $this->assertEquals( 2, $output['pageSize'] );
        $this->assertTrue( $output['onlyShowLatestEvent'] );

        $this->assertEquals( 2, count( $output['filterEvents'] ) );
    }
}