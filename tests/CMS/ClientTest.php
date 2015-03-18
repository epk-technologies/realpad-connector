<?php
namespace RealPadConnectorTests;

use RealPadConnector\CMS\Client;

class ClientTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Client
     */
    protected $client;

    function setUp()
    {
        $this->client = new Client(
            REALPAD_TEST_ENDPOINT,
            REALPAD_TEST_CMS_LOGIN,
            REALPAD_TEST_CMS_PASSWORD
        );
    }

}