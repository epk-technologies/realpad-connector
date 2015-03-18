<?php
namespace RealPadConnectorTests\CMS\Project;

use RealPadConnector\CMS\Project\Floor;

class FloorTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers Floor::createFromXML
     */
    function test_createFromXML()
    {
        $xml_source = '
            <floor id="1220529" floorNo="4" arrow-direction="2" plan="d3896ab3-c8fa-4ae5-a501-181f22d9427d" coordinates="797,178,972,238">
                <flat id="1000" plan="5cf1b05a-9964-4661-ac42-a96c77881000" coordinates="66,26,471,415" pdf="2a81f515-8fe5-4cd3-a6cb-89c8d892ae46">
                    <flat-attribute key="flat_internal_id" value="F11"/>
                    <picture id="84444" creation-time="2013-05-20T00:00:00+0200" resource="a8642693-2e65-43c5-a1bf-c377f1f283ac">
                        <name locale="cs_CZ" text="F11"/>
                        <name locale="en_US" text="F11"/>
                        <name locale="ru_RU" text="F11"/>
                    </picture>
                </flat>
                <flat id="2000" plan="5cf1b05a-9964-4661-ac42-a96c77882000" coordinates="66,26,471,415" pdf="2a81f515-8fe5-4cd3-a6cb-89c8d892ae46">
                    <flat-attribute key="flat_internal_id" value="F11"/>
                    <picture id="84444" creation-time="2013-05-20T00:00:00+0200" resource="a8642693-2e65-43c5-a1bf-c377f1f283ac">
                        <name locale="cs_CZ" text="F11"/>
                        <name locale="en_US" text="F11"/>
                        <name locale="ru_RU" text="F11"/>
                    </picture>
                </flat>
            </floor>
            ';
        $element = new \SimpleXMLElement($xml_source);
        $floor = Floor::createFromXML($element);

        $this->assertInstanceOf('RealPadConnector\CMS\Project\Floor', $floor);
        $this->assertEquals(1220529, $floor->getID());
        $this->assertEquals(4, $floor->getFloorNumber());
        $this->assertEquals(2, $floor->getArrowDirection());
        $this->assertEquals('d3896ab3-c8fa-4ae5-a501-181f22d9427d', $floor->getPlanResourceID());
        $this->assertEquals(array(797,178,972,238), $floor->getCoordinates());

        $this->assertEquals(2, count($floor));
        $this->assertInstanceOf('RealPadConnector\CMS\Project\Flat', $floor->getFlat(2000));
        $this->assertEquals('5cf1b05a-9964-4661-ac42-a96c77881000', $floor->getFlat(1000)->getPlanResourceID());
    }

}