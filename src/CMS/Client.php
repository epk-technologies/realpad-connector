<?php
namespace RealPadConnector\CMS;

use RealPadConnector\AbstractClient;

class Client extends AbstractClient {

    const SERVICE_LIST_PROJECTS = 'list-projects';
    const SERVICE_GET_ALL_PROJECTS = 'get-all-projects';
    const SERVICE_GET_PROJECT = 'get-project';

    /**
     * @return ListProjects\Export
     */
    function listProjects()
    {
        $xml = $this->sendRequest(self::SERVICE_LIST_PROJECTS, array(), $response);
        $export = ListProjects\Export::createFromXML($xml);
        return $export;
    }

    /**
     * @param int $screen_ID [optional]
     * @return GetAllProjects\Export
     */
    function getAllProjects($screen_ID = 2)
    {
        $xml = $this->sendRequest(
            self::SERVICE_GET_ALL_PROJECTS,
            array('screenid' => (int)$screen_ID),
            $response
        );
        $export = GetAllProjects\Export::createFromXML($xml);
        return $export;
    }

    /**
     * @param int $ID
     * @param int $developer_ID
     * @param int $screen_ID [optional]
     * @return Project
     */
    function getProject($ID, $developer_ID, $screen_ID = 2)
    {
        $xml = $this->sendRequest(
            self::SERVICE_GET_PROJECT,
            array(
                "developerid" => (int)$developer_ID,
                "projectid" => (int)$ID,
                "screenid" => (int)$screen_ID
            ),
            $response
        );
        $project = Project::createFromXML($xml);
        return $project;
    }
}