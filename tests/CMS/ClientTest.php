<?php
namespace RealPadConnectorTests\CMS;

use RealPadConnector\CMS\Client;

class ClientTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Client
     */
    protected $client;

    function setUp()
    {
        $this->client = new Client(
            REALPAD_TEST_CMS_ENDPOINT,
            REALPAD_TEST_CMS_LOGIN,
            REALPAD_TEST_CMS_PASSWORD
        );
    }

    function test_listProjects()
    {
        $export = $this->client->listProjects();
        $this->assertNotEmpty($export->getProjects());
        $this->assertInstanceOf('RealPadConnector\CMS\ListProjects\ProjectSimple', $export->getProject(REALPAD_TEST_CMS_PROJECT_ID));
    }

    function test_getAllProjects()
    {
        $export = $this->client->getAllProjects();
        $this->assertNotEmpty($export->getProjects());
        $this->assertInstanceOf('RealPadConnector\CMS\Project', $export->getProject(REALPAD_TEST_CMS_PROJECT_ID));
    }

    function test_getProject()
    {
        $project = $this->client->getProject(REALPAD_TEST_CMS_PROJECT_ID, REALPAD_TEST_CMS_DEVELOPER_ID);
        $this->assertInstanceOf('RealPadConnector\CMS\Project', $project);
    }
}