<?php
namespace RealPadConnectorTests\CRM;

use RealPadConnector\CRM\Client;
use RealPadConnector\CRM\Lead;

class ClientTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Client
     */
    protected $client;

    function setUp()
    {
        $this->client = new Client(
            REALPAD_TEST_CRM_ENDPOINT,
            REALPAD_TEST_CRM_LOGIN,
            REALPAD_TEST_CRM_PASSWORD
        );
    }

    function test_listLeads()
    {
        $leads = $this->client->listLeads();
        $this->assertInstanceOf('RealPadConnector\CRM\LeadsList', $leads);
    }

    function test_createLead()
    {
        $lead = new Lead();
        $lead->setName('TestingName');
        $lead->setSurname('TestingSurname');
        $lead->setEmail('test@test.cz');
        $lead->setPhone('123456789');
        $lead->setNote('This is testing lead, please ignore it');

        $ID = $this->client->createLead($lead);
        $this->assertGreaterThan(0, $ID);
    }

}