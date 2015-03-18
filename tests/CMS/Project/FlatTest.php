<?php
namespace RealPadConnectorTests\CMS\Project;

use RealPadConnector\CMS\Project\Flat;

class FlatTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers Flat::createFromXML
     */
    function test_createFromXML()
    {
        $xml_source = '
            <flat id="48504" plan="5cf1b05a-9964-4661-ac42-a96c778842a3" coordinates="66,26,471,415" pdf="2a81f515-8fe5-4cd3-a6cb-89c8d892ae46">
                <flat-attribute key="flat_internal_id" value="F11"/>
                <flat-attribute key="flat_disposition" value="3+kk"/>
                <flat-attribute key="flat_area" value="75.4"/>
                <flat-attribute key="flat_area_living"/>
                <flat-attribute key="flat_area_balcony" value="0.0"/>
                <flat-attribute key="flat_area_terrace"/>
                <flat-attribute key="flat_area_garden" value="109.0"/>
                <flat-attribute key="flat_price" value="4510044"/>
                <flat-attribute key="flat_discount_vat" value="250000"/>
                <flat-attribute key="flat_discount_without_vat" value="217391"/>
                <flat-attribute key="flat_price_before_discount_vat" value="4760044"/>
                <flat-attribute key="flat_price_before_discount_without_vat" value="4139168"/>
                <flat-attribute key="flat_status" value="3"/>
                <flat-attribute key="flat_monthly_loan_payment" value="13322"/>
                <flat-attribute key="flat_type" value="1"/>
                <flat-attribute key="flat_orientation" value="JZ"/>
                <picture id="84444" creation-time="2013-05-20T00:00:00+0200" resource="a8642693-2e65-43c5-a1bf-c377f1f283ac">
                    <name locale="cs_CZ" text="F11"/>
                    <name locale="en_US" text="F11"/>
                    <name locale="ru_RU" text="F11"/>
                </picture>
            </flat>
            ';
        $element = new \SimpleXMLElement($xml_source);
        $flat = Flat::createFromXML($element);

        $this->assertInstanceOf('RealPadConnector\CMS\Project\Flat', $flat);
        $this->assertEquals(48504, $flat->getID());
        $this->assertEquals('5cf1b05a-9964-4661-ac42-a96c778842a3', $flat->getPlanResourceID());
        $this->assertEquals(array(66,26,471,415), $flat->getCoordinates());
        $this->assertEquals('2a81f515-8fe5-4cd3-a6cb-89c8d892ae46', $flat->getPDFResourceID());

        $this->assertEquals('F11', $flat['flat_internal_id']);
        $this->assertSame(null, $flat['flat_area_terrace']);

        $picture = $flat->getPicture(84444);
        $this->assertInstanceOf('RealPadConnector\CMS\Project\Picture', $picture);

        $first_picture = $flat->getFirstPicture();
        $this->assertSame($picture, $first_picture);
    }

}