<?php
namespace RealPadConnectorTests\CMS\Project;

use RealPadConnector\CMS\Project\POI;

class POITest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers POI::createFromXML
     */
    function test_createFromXML()
    {
        $xml_source = '
            <poi id="1220108" gps="50.132656,14.451263" resource="acd546f0-83a1-42ed-9e15-c294e3b72fdd">
                <name locale="cs_CZ" text="Penny market"/>
                <name locale="en_US" text="Supermarket Penny"/>
                <name locale="ru_RU" text="супермаркет"/>
            </poi>
            ';
        $element = new \SimpleXMLElement($xml_source);
        $poi = POI::createFromXML($element);

        $this->assertInstanceOf('RealPadConnector\CMS\Project\POI', $poi);
        $this->assertEquals(1220108, $poi->getID());
        $this->assertEquals(array(50.132656,14.451263), $poi->getGPS());
        $this->assertEquals('acd546f0-83a1-42ed-9e15-c294e3b72fdd', $poi->getResourceID());
        $this->assertEquals(array(
            'cs_CZ' => 'Penny market',
            'en_US' => 'Supermarket Penny',
            'ru_RU' => 'супермаркет',
        ), $poi->getNames());

    }

}