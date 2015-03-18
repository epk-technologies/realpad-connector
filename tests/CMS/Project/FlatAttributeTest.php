<?php
namespace RealPadConnectorTests\CMS\Project;

use RealPadConnector\CMS\Project\FlatAttribute;

class FlatAttributeTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers FlatAttribute::createFromXML
     */
    function test_createFromXML()
    {
        $xml_source = '
            <flat-attribute-type key="flat_type" type="6" required="false" filterable="true" show-in-pricelist="false" pricelist-priority="15" show-in-detail="true" detail-priority="1">
                <name locale="cs_CZ" text="Typ produktu"/>
                <name locale="en_US" text="Product type"/>
                <name locale="ru_RU" text="Тип недвижимости"/>
                <enum value="1" priority="1">
                    <label locale="cs_CZ" text="Byt"/>
                    <label locale="en_US" text="Flat"/>
                    <label locale="ru_RU" text="Квартира"/>
                </enum>
                <enum value="2" priority="2">
                    <label locale="cs_CZ" text="Parking"/>
                    <label locale="en_US" text="Parking"/>
                    <label locale="ru_RU" text="Паркинг"/>
                </enum>
            </flat-attribute-type>
            ';
        $element = new \SimpleXMLElement($xml_source);
        $flat_attribute = FlatAttribute::createFromXML($element);

        $this->assertInstanceOf('RealPadConnector\CMS\Project\FlatAttribute', $flat_attribute);
        $this->assertEquals('flat_type', $flat_attribute->getKey());
        $this->assertEquals(6, $flat_attribute->getType());
        $this->assertEquals(false, $flat_attribute->isRequired());
        $this->assertEquals(true, $flat_attribute->isFilterable());
        $this->assertEquals(false, $flat_attribute->showInPriceList());
        $this->assertEquals(15, $flat_attribute->getPriceListPriority());
        $this->assertEquals(true, $flat_attribute->showInDetail());
        $this->assertEquals(1, $flat_attribute->getDetailPriority());

        $this->assertEquals(array(
            'cs_CZ' => 'Typ produktu',
            'en_US' => 'Product type',
            'ru_RU' => 'Тип недвижимости',
        ), $flat_attribute->getNames());

        $this->assertEquals(array(
            'cs_CZ' => array(1 => "Byt", 2 => "Parking"),
            'en_US' => array(1 => "Flat", 2 => "Parking"),
            'ru_RU' => array(1 => "Квартира", 2 => "Паркинг"),
        ), $flat_attribute->getValueOptions());

        $this->assertEquals(array(1 => "Byt", 2 => "Parking"), $flat_attribute->getValueOptions('cs_CZ'));

    }

}