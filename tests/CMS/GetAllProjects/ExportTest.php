<?php
namespace RealPadConnectorTests\CMS\GetAllProjects;

use RealPadConnector\CMS\GetAllProjects\Export;

class ExportTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers Export::createFromXML
     */
    function test_createFromXML()
    {
        $xml_source = '
            <export creation-time="2015-03-18T22:10:29+0100" developer-id="35737" developer-name="StarXXX" url="http://starxxx.cz/" tracking-id="UA-40595565-1" logo="cf1a82af-e62a-4550-9377-ee790aff81f9" allows-reservations="true">
                <project id="35742" name="Kejřův park 2" stage="1" gps="50.101602,14.529097" gps-center="50.079582,14.430068" city="Praha" plan="f1ab126b-7fde-49f9-8a1d-8b8e538e50ff" icon="1065ed72-cbaa-4c76-81fc-b10dc4d3797b" standards="fc1be882-2d97-488b-babe-54ef7c87cd65" offline-map="9804638e-c737-48b1-802d-088aa78cecfd" hypo-assistant="true" public="false" hidden="false" demo="false" currency="CZK">
                </project>
                <project id="35743" name="Kejřův park 4" stage="1" gps="50.101602,14.529097" gps-center="50.079582,14.430068" city="Praha" plan="f1ab126b-7fde-49f9-8a1d-8b8e538e50ff" icon="1065ed72-cbaa-4c76-81fc-b10dc4d3797b" standards="fc1be882-2d97-488b-babe-54ef7c87cd65" offline-map="9804638e-c737-48b1-802d-088aa78cecfd" hypo-assistant="true" public="false" hidden="false" demo="false" currency="CZK">
                </project>
            </export>
            ';
        $element = new \SimpleXMLElement($xml_source);
        $export = Export::createFromXML($element);

        $this->assertInstanceOf('RealPadConnector\CMS\GetAllProjects\Export', $export);
        $this->assertEquals(new \DateTime('2015-03-18T22:10:29+0100'), $export->getCreationTime());
        $this->assertEquals(35737, $export->getDeveloperID());
        $this->assertEquals('StarXXX', $export->getDeveloperName());
        $this->assertEquals('http://starxxx.cz/', $export->getURL());
        $this->assertEquals('UA-40595565-1', $export->getTrackingID());
        $this->assertEquals('cf1a82af-e62a-4550-9377-ee790aff81f9', $export->getLogoResourceID());
        $this->assertTrue($export->allowsReservations());

        $this->assertEquals(2, count($export));
        $this->assertInstanceOf('RealPadConnector\CMS\Project', $export->getProject(35742));
    }

}