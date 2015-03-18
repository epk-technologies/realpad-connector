<?php
namespace RealPadConnectorTests\CMS\Project;

use RealPadConnector\CMS\Project\Gallery;

class GalleryTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers Gallery::createFromXML
     */
    function test_createFromXML()
    {
        $xml_source = '
            <gallery id="1219895" creation-time="2014-08-21T00:00:00+0200" modification-time="2014-08-21T00:00:00+0200" type="2">
                <name locale="cs_CZ" text="Exteriérové vizualizace"/>
                <name locale="en_US" text="Exterior visualizations"/>
                <name locale="ru_RU" text="Визуализации экстерьера"/>
                <picture id="1223587" creation-time="2014-08-21T00:00:00+0200" resource="759dc2aa-f32f-447a-97b6-993c870f34ea"/>
                <picture id="1223659" creation-time="2014-08-21T00:00:00+0200" resource="06875e60-96b2-4430-8099-47eeec584a7d"/>
            </gallery>
            ';
        $element = new \SimpleXMLElement($xml_source);
        $gallery = Gallery::createFromXML($element);

        $this->assertInstanceOf('RealPadConnector\CMS\Project\Gallery', $gallery);
        $this->assertEquals(1219895, $gallery->getID());
        $this->assertEquals(new \DateTime('2014-08-21T00:00:00+0200'), $gallery->getCreationTime());
        $this->assertEquals(new \DateTime('2014-08-21T00:00:00+0200'), $gallery->getModificationTime());
        $this->assertEquals(2, $gallery->getType());
        $this->assertEquals(array(
            'cs_CZ' => 'Exteriérové vizualizace',
            'en_US' => 'Exterior visualizations',
            'ru_RU' => 'Визуализации экстерьера',
        ), $gallery->getNames());

        $this->assertEquals(2, count($gallery));
        $this->assertInstanceOf('RealPadConnector\CMS\Project\Picture', $gallery->getPicture(1223659));

    }

}