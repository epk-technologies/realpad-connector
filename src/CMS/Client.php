<?php
namespace RealPadConnector\CMS;

use RealPadConnector\AbstractClient;

class Client extends AbstractClient {

    const SERVICE_LIST_PROJECTS = 'list-projects';
    const SERVICE_GET_ALL_PROJECTS = 'get-all-projects';

    function listProjects()
    {
        $xml = $this->sendRequest(self::SERVICE_LIST_PROJECTS, array(), $response);
        die(var_dump($response->raw_body));
    }

}