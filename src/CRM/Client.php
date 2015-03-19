<?php
namespace RealPadConnector\CRM;

use Httpful\Mime;
use RealPadConnector\AbstractClient;

class Client extends AbstractClient {

    const SERVICE_CREATE_LEAD = 'create-lead';
    const SERVICE_LIST_LEADS = 'list-leads';

    /**
     * @return LeadsList|array
     * @throws \RealPadConnector\Exception
     */
    function listLeads()
    {
        $xml = $this->sendRequest(self::SERVICE_LIST_LEADS);
        $list = LeadsList::createFromXML($xml);
        return $list;
    }

    /**
     * @param Lead $lead
     * @return int
     * @throws \RealPadConnector\Exception
     */
    function createLead(Lead $lead)
    {
        $ID = (int)$this->sendRequest(
            self::SERVICE_CREATE_LEAD,
            $lead->getParameters(),
            $response,
            Mime::PLAIN
        );

        $lead->setID($ID);
        return $ID;
    }

}