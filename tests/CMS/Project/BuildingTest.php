<?php
namespace RealPadConnectorTests\CMS\Project;

use RealPadConnector\CMS\Project\Building;

class BuildingTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers Building::createFromXML
     */
    function test_createFromXML()
    {
        $xml_source = '
            <building id="48383" name="F" gps="12.5,13.5" arrow-direction="2" plan="b79b87f1-67cd-48b4-a3ca-ae63fad89505" coordinates="393,342,864,671">
                <floor id="10000" floorNo="3" arrow-direction="2" plan="d3896ab3-c8fa-4ae5-a501-181f22d9427d" coordinates="797,178,972,238">
                    <flat id="1000" plan="5cf1b05a-9964-4661-ac42-a96c77881000" coordinates="66,26,471,415" pdf="2a81f515-8fe5-4cd3-a6cb-89c8d892ae46">
                        <flat-attribute key="flat_internal_id" value="F11"/>
                    </flat>
                    <flat id="2000" plan="5cf1b05a-9964-4661-ac42-a96c77882000" coordinates="66,26,471,415" pdf="2a81f515-8fe5-4cd3-a6cb-89c8d892ae46">
                        <flat-attribute key="flat_internal_id" value="F11"/>
                    </flat>
                </floor>
                <floor id="20000" floorNo="4" arrow-direction="2" plan="d3896ab3-c8fa-4ae5-a501-181f22d9427d" coordinates="797,178,972,238">
                    <flat id="3000" plan="5cf1b05a-9964-4661-ac42-a96c77881000" coordinates="66,26,471,415" pdf="2a81f515-8fe5-4cd3-a6cb-89c8d892ae46">
                        <flat-attribute key="flat_internal_id" value="F11"/>
                    </flat>
                    <flat id="4000" plan="5cf1b05a-9964-4661-ac42-a96c77882000" coordinates="66,26,471,415" pdf="2a81f515-8fe5-4cd3-a6cb-89c8d892ae46">
                        <flat-attribute key="flat_internal_id" value="F11"/>
                    </flat>
                </floor>
            </building>
            ';
        $element = new \SimpleXMLElement($xml_source);
        $building = Building::createFromXML($element);

        $this->assertInstanceOf('RealPadConnector\CMS\Project\Building', $building);
        $this->assertEquals(48383, $building->getID());
        $this->assertEquals('F', $building->getName());
        $this->assertEquals(array(12.5,13.5), $building->getGPS());
        $this->assertEquals(2, $building->getArrowDirection());
        $this->assertEquals('b79b87f1-67cd-48b4-a3ca-ae63fad89505', $building->getPlanResourceID());
        $this->assertEquals(array(393,342,864,671), $building->getCoordinates());

        $this->assertEquals(2, count($building));
        $this->assertInstanceOf('RealPadConnector\CMS\Project\Floor', $building->getFloor(20000));
        $this->assertEquals('d3896ab3-c8fa-4ae5-a501-181f22d9427d', $building->getFloor(10000)->getPlanResourceID());

        $this->assertEquals(4, count($building->getFlats()));
    }

}