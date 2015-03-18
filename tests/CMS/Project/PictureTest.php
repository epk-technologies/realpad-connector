<?php
namespace RealPadConnectorTests\CMS\Project;

use RealPadConnector\CMS\Project\Picture;

class PictureTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers Picture::createFromXML
     */
    function test_createFromXML()
    {
        $xml_source = '
            <picture id="84444" creation-time="2013-05-20T00:00:00+0200" resource="a8642693-2e65-43c5-a1bf-c377f1f283ac">
                <name locale="cs_CZ" text="F11"/>
                <name locale="en_US" text="F11"/>
                <name locale="ru_RU" text="F11"/>
            </picture>
            ';
        $element = new \SimpleXMLElement($xml_source);
        $picture = Picture::createFromXML($element);

        $this->assertInstanceOf('RealPadConnector\CMS\Project\Picture', $picture);
        $this->assertEquals(84444, $picture->getID());
        $this->assertEquals(new \DateTime('2013-05-20T00:00:00+0200'), $picture->getCreationTime());
        $this->assertEquals('a8642693-2e65-43c5-a1bf-c377f1f283ac', $picture->getResourceID());
        $this->assertEquals(array(
            'cs_CZ' => 'F11',
            'en_US' => 'F11',
            'ru_RU' => 'F11',
        ), $picture->getNames());

    }

}