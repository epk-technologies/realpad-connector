<?php
namespace RealPadConnectorTests\CMS\Project;

use RealPadConnector\CMS\Project;

class ProjectTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers Project::createFromXML
     */
    function test_createFromXML()
    {
        $xml_source = '
            <project id="35742" name="Kejřův park 2" stage="1" gps="50.101602,14.529097" gps-center="50.079582,14.430068" city="Praha" plan="f1ab126b-7fde-49f9-8a1d-8b8e538e50ff" icon="1065ed72-cbaa-4c76-81fc-b10dc4d3797b" standards="fc1be882-2d97-488b-babe-54ef7c87cd65" offline-map="9804638e-c737-48b1-802d-088aa78cecfd" hypo-assistant="true" public="true" hidden="true" demo="true" currency="CZK">

                <locale iso="cs_CZ" name="Čeština"/>
                <locale iso="en_US" name="English"/>
                <locale iso="ru_RU" name="Русский"/>

                <description locale="cs_CZ" text="Kejřův park 2"/>
                <description locale="en_US" text="Kejřův park 2"/>
                <description locale="ru_RU" text="Кейржув парк 2"/>

                <email-header locale="cs_CZ" text="Dobrý den pane/paní,{nl} {nl} na základě naší schůzky si Vám dovoluji zaslat slíbené infrmace.{nl} {nl}"/>
                <email-header locale="en_US" text="Dear valued customer,{nl} {nl} Based on our meeting, I am sending you information about your favorite apartments.{nl} {nl}"/>
                <email-header locale="ru_RU" text="Добрый день,{nl} {nl} как мы и договорились, посылаю вам обещанные документы.{nl} {nl}"/>

                <email locale="cs_CZ" text="Dobrý den pane/paní,{nl} {nl} na základě naší schůzky si Vám dovoluji zaslat slíbené infrmace.{nl} {nl} Jednotka: {flat_internal_id} {project}{nl} Dispozice: {flat_disposition}{nl} Plocha: {flat_area}{nl} Cena: {flat_price}{nl} {nl} Katalogové listy bytů zasílám v příloze a v případě dotazů jsem Vám k dispozici.{nl}"/>
                <email locale="en_US" text="Dear valued customer,{nl} {nl} Based on our meeting, I am sending you information about your favorite apartments.{nl} {nl} Unit: {flat_internal_id} {project}{nl} Disposition: {flat_disposition}{nl} Area: {flat_area}{nl} Price: {flat_price}{nl} {nl} Please find a floorplan attached. Should you have any questions please feel free to contact me.{nl}"/>
                <email locale="ru_RU" text="Добрый день,{nl} {nl} как мы и договорились, посылаю вам обещанные документы.{nl} {nl} Квартира: {flat_internal_id} {project}{nl} Планировка: {flat_disposition}{nl} Площадь: {flat_area}{nl} Цена: {flat_price}{nl} {nl} К письму прицеплен лист из каталога. В случае, если у вас возникнут вопросы не ждите, обращайтесь к нам.{nl}"/>

                <email-footer locale="cs_CZ" text="Katalogové listy bytů zasílám v příloze a v případě dotazů jsem Vám k dispozici.{nl}"/>
                <email-footer locale="en_US" text="Please find a floorplan attached. Should you have any questions please feel free to contact me.{nl}"/>
                <email-footer locale="ru_RU" text="К письму прицеплен лист из каталога. В случае, если у вас возникнут вопросы не ждите, обращайтесь к нам.{nl}"/>

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

                <building id="48385" name="F" gps="12.5,13.5" arrow-direction="2" plan="b79b87f1-67cd-48b4-a3ca-ae63fad89505" coordinates="393,342,864,671">
                    <floor id="30000" floorNo="3" arrow-direction="2" plan="d3896ab3-c8fa-4ae5-a501-181f22d9427d" coordinates="797,178,972,238">
                        <flat id="5000" plan="5cf1b05a-9964-4661-ac42-a96c77881000" coordinates="66,26,471,415" pdf="2a81f515-8fe5-4cd3-a6cb-89c8d892ae46">
                            <flat-attribute key="flat_internal_id" value="F11"/>
                        </flat>
                        <flat id="6000" plan="5cf1b05a-9964-4661-ac42-a96c77882000" coordinates="66,26,471,415" pdf="2a81f515-8fe5-4cd3-a6cb-89c8d892ae46">
                            <flat-attribute key="flat_internal_id" value="F11"/>
                        </flat>
                    </floor>
                    <floor id="40000" floorNo="4" arrow-direction="2" plan="d3896ab3-c8fa-4ae5-a501-181f22d9427d" coordinates="797,178,972,238">
                        <flat id="7000" plan="5cf1b05a-9964-4661-ac42-a96c77881000" coordinates="66,26,471,415" pdf="2a81f515-8fe5-4cd3-a6cb-89c8d892ae46">
                            <flat-attribute key="flat_internal_id" value="F11"/>
                        </flat>
                        <flat id="8000" plan="5cf1b05a-9964-4661-ac42-a96c77882000" coordinates="66,26,471,415" pdf="2a81f515-8fe5-4cd3-a6cb-89c8d892ae46">
                            <flat-attribute key="flat_internal_id" value="F11"/>
                        </flat>
                    </floor>
                </building>


                <gallery id="904366" creation-time="2014-04-17T00:00:00+0200" modification-time="2014-04-17T00:00:00+0200" type="8">
                    <name locale="cs_CZ" text="Dokumenty"/>
                    <name locale="en_US" text="Documents"/>
                    <name locale="ru_RU" text="документация"/>
                    <picture id="904369" creation-time="2014-04-17T00:00:00+0200" resource="19d53de9-96c6-44f0-af4b-c67990b640ed">
                        <name locale="cs_CZ" text="Katalog standardního vybavení"/>
                        <name locale="en_US" text="Product standard equipment"/>
                        <name locale="ru_RU" text="Стандарт продукции оборудование"/>
                    </picture>
                    <picture id="904375" creation-time="2014-04-17T00:00:00+0200" resource="f1e12322-c0a1-4c3a-b053-d8e4b6ec38c6">
                        <name locale="cs_CZ" text="Ceník"/>
                        <name locale="en_US" text="Pricelist"/>
                        <name locale="ru_RU" text="прайс-лист"/>
                    </picture>
                </gallery>

                <gallery id="9043660" creation-time="2014-04-17T00:00:00+0200" modification-time="2014-04-17T00:00:00+0200" type="8">
                    <name locale="cs_CZ" text="Dokumenty"/>
                    <name locale="en_US" text="Documents"/>
                    <name locale="ru_RU" text="документация"/>
                    <picture id="9043690" creation-time="2014-04-17T00:00:00+0200" resource="19d53de9-96c6-44f0-af4b-c67990b640ed">
                        <name locale="cs_CZ" text="Katalog standardního vybavení"/>
                        <name locale="en_US" text="Product standard equipment"/>
                        <name locale="ru_RU" text="Стандарт продукции оборудование"/>
                    </picture>
                    <picture id="9043750" creation-time="2014-04-17T00:00:00+0200" resource="f1e12322-c0a1-4c3a-b053-d8e4b6ec38c6">
                        <name locale="cs_CZ" text="Ceník"/>
                        <name locale="en_US" text="Pricelist"/>
                        <name locale="ru_RU" text="прайс-лист"/>
                    </picture>
                </gallery>

                <poi id="49190" gps="50.102125,14.536776" resource="77870039-7ae9-45fe-bb07-956182e69e82">
                    <name locale="cs_CZ" text="Mateřská školka"/>
                    <name locale="en_US" text="Nursery"/>
                    <name locale="ru_RU" text="Садик"/>
                </poi>

                <poi id="49193" gps="50.101602,14.527626" resource="77870039-7ae9-45fe-bb07-956182e69e82">
                    <name locale="cs_CZ" text="Mateřská školka"/>
                    <name locale="en_US" text="Nursery"/>
                    <name locale="ru_RU" text="Садик"/>
                </poi>

                <flat-attribute-type key="flat_internal_id" type="1" required="false" filterable="false" show-in-pricelist="true" pricelist-priority="10" show-in-detail="true" detail-priority="10">
                    <name locale="cs_CZ" text="ID"/>
                    <name locale="en_US" text="ID"/>
                    <name locale="ru_RU" text="Внутрений номер"/>
                    <name locale="sk_SK" text="ID"/>
                    <name locale="uk_UA" text="Внутрішній номер"/>
                </flat-attribute-type>

                <flat-attribute-type key="flat_type" type="6" required="false" filterable="true" show-in-pricelist="false" pricelist-priority="15" show-in-detail="true" detail-priority="1">
                    <name locale="cs_CZ" text="Typ produktu"/>
                    <name locale="en_US" text="Product type"/>
                    <name locale="ru_RU" text="Тип недвижимости"/>
                    <enum value="1" priority="1">
                        <label locale="cs_CZ" text="Byt"/>
                        <label locale="en_US" text="Flat"/>
                        <label locale="ru_RU" text="Квартира"/>
                    </enum>
                </flat-attribute-type>
            </project>
            ';
        $element = new \SimpleXMLElement($xml_source);
        $project = Project::createFromXML($element);

        $this->assertInstanceOf('RealPadConnector\CMS\Project', $project);
        $this->assertEquals(35742, $project->getID());
        $this->assertEquals('Kejřův park 2', $project->getName());
        $this->assertEquals('1', $project->getStage());
        $this->assertEquals(array(50.101602,14.529097), $project->getGPS());
        $this->assertEquals(array(50.079582,14.430068), $project->getGPSCenter());
        $this->assertEquals('Praha', $project->getCity());
        $this->assertEquals('f1ab126b-7fde-49f9-8a1d-8b8e538e50ff', $project->getPlanResourceID());
        $this->assertEquals('1065ed72-cbaa-4c76-81fc-b10dc4d3797b', $project->getIconResourceID());
        $this->assertEquals('fc1be882-2d97-488b-babe-54ef7c87cd65', $project->getStandardsResourceID());
        $this->assertEquals('9804638e-c737-48b1-802d-088aa78cecfd', $project->getOfflineMapResourceID());
        $this->assertTrue($project->isHypoAssistantEnabled());
        $this->assertTrue($project->isPublic());
        $this->assertTrue($project->isHidden());
        $this->assertTrue($project->isDemo());
        $this->assertEquals('CZK', $project->getCurrency());

        $this->assertEquals(2, count($project));
        $this->assertInstanceOf('RealPadConnector\CMS\Project\Building', $project->getBuilding(48383));

        $this->assertEquals(4, count($project->getFloors()));
        $this->assertEquals(8, count($project->getFlats()));

        $this->assertEquals(array(
            'cs_CZ' => 'Čeština',
            'en_US' => 'English',
            'ru_RU' => 'Русский',
        ), $project->getLocales());
        $this->assertEquals('Čeština', $project->getLocale('cs_CZ'));

        $this->assertEquals(array(
            'cs_CZ' => 'Kejřův park 2',
            'en_US' => 'Kejřův park 2',
            'ru_RU' => 'Кейржув парк 2',
        ), $project->getDescriptions());
        $this->assertEquals('Кейржув парк 2', $project->getDescription('ru_RU'));

        $this->assertEquals(3, count($project->getEmailHeaders()));
        $this->assertEquals(3, count($project->getEmailFooters()));
        $this->assertEquals(3, count($project->getEmails()));

        $this->assertEquals(2, count($project->getPOIs()));
        $this->assertInstanceOf('RealPadConnector\CMS\Project\POI', $project->getPOI(49190));

        $this->assertEquals(2, count($project->getPOIs()));
        $this->assertInstanceOf('RealPadConnector\CMS\Project\POI', $project->getPOI(49190));

        $this->assertEquals(2, count($project->getGalleries()));
        $this->assertEquals(4, count($project->getGalleriesPictures()));
        $this->assertInstanceOf('RealPadConnector\CMS\Project\Gallery', $project->getGallery(9043660));

        $this->assertEquals(2, count($project->getFlatAttributes()));
        $this->assertInstanceOf('RealPadConnector\CMS\Project\FlatAttribute', $project->getFlatAttribute('flat_internal_id'));
    }

}