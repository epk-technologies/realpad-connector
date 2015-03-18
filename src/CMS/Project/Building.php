<?php
namespace RealPadConnector\CMS\Project;

use RealPadConnector\Object;
use RealPadConnector\Utils;

class Building extends Object implements \Iterator, \Countable {

    /**
     * @var Floor[]|Flat[][]
     */
    protected $floors = array();

    /**
     * @param string $parameter
     * @param mixed $value
     */
    function setParameter($parameter, $value)
    {
        switch($parameter){

            case 'coordinates':
                $value = Utils::formatCoordinates($value);
                break;

            case 'gps':
                $value = Utils::formatGPS($value);
                break;

            default:

        }
        parent::setParameter($parameter, $value);

    }

    /**
     * @return int
     */
    function getID()
    {
        return (int)$this['id'];
    }

    /**
     * @return string
     */
    function getName()
    {
        return (string)$this['name'];
    }

    /**
     * @return array|null
     */
    function getGPS()
    {
        return $this['gps'];
    }

    /**
     * @return int
     */
    function getArrowDirection()
    {
        return (int)$this['arrow-direction'];
    }


    /**
     * @return string
     */
    function getPlanResourceID()
    {
        return (string)$this['plan'];
    }
    /**
     * @return array|null
     */
    function getCoordinates()
    {
        return $this['coordinates'];
    }


    /**
     * @return Floor[]
     */
    public function getFloors()
    {
        return $this->floors;
    }

    /**
     * @param Floor[] $floors
     */
    public function setFloors(array $floors)
    {
        $this->floors = array();
        foreach($floors as $floor){
            $this->addFloor($floor);
        }
    }

    /**
     * @param Floor $floor
     */
    public function addFloor(Floor $floor)
    {
        $this->floors[$floor->getID()] = $floor;
    }

    /**
     * @param int $ID
     * @return null|Floor
     */
    function getFloor($ID)
    {
        return isset($this->floors[$ID])
            ? $this->floors[$ID]
            : null;
    }


    /**
     * @return Flat[]
     */
    function getFlats()
    {
        $output = array();
        foreach($this->floors as $floor){
            $output = array_merge($output, $floor->getFlats());
        }
        return $output;
    }

    /**
     * @param \SimpleXMLElement $element
     * @return Building
     */
    public static function createFromXML(\SimpleXMLElement $element)
    {
        /** @var Building $building */
        $building = parent::createFromXML($element);

        if(isset($element->floor)){
            foreach($element->floor as $floor_element)
            {
                $floor = Floor::createFromXML($floor_element);
                $building->addFloor($floor);
            }
        }

        $attributes = Utils::fetchChildAttributePairs($element, 'building-attribute', 'key', 'value');
        foreach($attributes as $attribute => $value){
            $building->setParameter($attribute, $value);
        }

        return $building;
    }

    /**
     * @return Floor|bool
     */
    public function current()
    {
        return current($this->floors);
    }

    public function next()
    {
        next($this->floors);
    }


    /**
     * @return int|null
     */
    public function key()
    {
        return key($this->floors);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return key($this->floors) !== null;
    }

    public function rewind()
    {
        reset($this->floors);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->floors);
    }
}