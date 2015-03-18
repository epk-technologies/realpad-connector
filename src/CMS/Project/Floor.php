<?php
namespace RealPadConnector\CMS\Project;

use RealPadConnector\Object;
use RealPadConnector\Utils;

class Floor extends Object implements \Iterator,\Countable {

    /**
     * @var Flat[]
     */
    protected $flats = array();

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
    function getPlanResourceID()
    {
        return (string)$this['plan'];
    }

    /**
     * @return int
     */
    function getFloorNumber()
    {
        return (int)$this['floorNo'];
    }

    /**
     * @return int
     */
    function getArrowDirection()
    {
        return (int)$this['arrow-direction'];
    }
    
    /**
     * @return array|null
     */
    function getCoordinates()
    {
        return $this['coordinates'];
    }


    /**
     * @return Flat[]
     */
    public function getFlats()
    {
        return $this->flats;
    }

    /**
     * @param Flat[] $flats
     */
    public function setFlats(array $flats)
    {
        $this->flats = array();
        foreach($flats as $flat){
            $this->addFlat($flat);
        }
    }

    /**
     * @param Flat $flat
     */
    public function addFlat(Flat $flat)
    {
        $this->flats[$flat->getID()] = $flat;
    }

    /**
     * @param int $ID
     * @return null|Flat
     */
    function getFlat($ID)
    {
        return isset($this->flats[$ID])
            ? $this->flats[$ID]
            : null;
    }




    /**
     * @param \SimpleXMLElement $element
     * @return Floor
     */
    public static function createFromXML(\SimpleXMLElement $element)
    {
        /** @var Floor $floor */
        $floor = parent::createFromXML($element);

        if(isset($element->flat)){
            foreach($element->flat as $flat_element) {
                $flat = Flat::createFromXML($flat_element);
                $floor->addFlat($flat);
            }
        }

        $attributes = Utils::fetchChildAttributePairs($element, 'floor-attribute', 'key', 'value');
        foreach($attributes as $attribute => $value){
            $floor->setParameter($attribute, $value);
        }

        return $floor;
    }

    /**
     * @return Flat
     */
    public function current()
    {
        return current($this->flats);
    }

    public function next()
    {
        next($this->flats);
    }


    /**
     * @return int|null
     */
    public function key()
    {
        return key($this->flats);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return key($this->flats) !== null;
    }

    public function rewind()
    {
        reset($this->flats);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->flats);
    }
}