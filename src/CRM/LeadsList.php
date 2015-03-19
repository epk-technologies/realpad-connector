<?php
namespace RealPadConnector\CRM;

use RealPadConnector\Object;
use RealPadConnector\Utils;

class LeadsList extends Object implements \Countable, \Iterator {

    const STATUS_LEAD = 1;
    const STATUS_LEAD_UNPROCESSED = 2;
    const STATUS_LEAD_PROCESSED = 3;
    const STATUS_LEAD_MEETING_SCHEDULED = 4;
    const STATUS_LEAD_MEETING_AFTER = 5;
    const STATUS_PRE_RESERVATION = 6;
    const STATUS_ACTIVE_RC_PREPARING = 7;
    const STATUS_ACTIVE_RC_SIGNED = 8;
    const STATUS_ACTIVE_RC_PAID = 9;
    const STATUS_ACTIVE_FPC_SIGNED = 10;
    const STATUS_ACTIVE_FPC_PAID = 11;
    const STATUS_ACTIVE_PC_PAID = 12;
    const STATUS_ACTIVE_PC_SIGNED = 13;
    const STATUS_INACTIVE_REFUSED = 14;
    const STATUS_INACTIVE_DUPLICATE = 15;
    const STATUS_INACTIVE_IRRELEVANT = 16;
    const STATUS_INACTIVE_SLEEPING = 17;

    /**
     * @var array
     */
    protected $leads_states = array();

    /**
     * @return array
     */
    public function getLeadsStates()
    {
        return $this->leads_states;
    }

    /**
     * @param array $leads_states
     */
    public function setLeadsStates(array $leads_states)
    {
        $this->leads_states = $leads_states;
    }

    /**
     * @param \SimpleXMLElement $element
     * @return LeadsList
     */
    public static function createFromXML(\SimpleXMLElement $element)
    {
        /** @var LeadsList $list */
        $list = parent::createFromXML($element);

        $states = Utils::fetchChildAttributePairs($element, 'lead', 'id', 'status');
        $list->setLeadsStates($states);

        return $list;
    }


    /**
     * @return int|bool
     */
    public function current()
    {
        return current($this->leads_states);
    }

    public function next()
    {
        next($this->leads_states);
    }


    /**
     * @return int|null
     */
    public function key()
    {
        return key($this->leads_states);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return key($this->leads_states) !== null;
    }

    public function rewind()
    {
        reset($this->leads_states);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->leads_states);
    }

}