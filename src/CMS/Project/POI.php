<?php
namespace RealPadConnector\CMS\Project;

use RealPadConnector\Object;
use RealPadConnector\Utils;

class POI extends Object {

    /**
     * @var array
     */
    protected $names = array();

    /**
     * @param string $parameter
     * @param mixed $value
     */
    function setParameter($parameter, $value)
    {
        switch($parameter){
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
    function getResourceID()
    {
        return (string)$this['resource'];
    }

    /**
     * @return array|null
     */
    function getGPS()
    {
        return $this['gps'];
    }

    /**
     * @return array
     */
    public function getNames()
    {
        return $this->names;
    }

    /**
     * @param array $names
     */
    public function setNames(array $names)
    {
        $this->names = array();
        foreach($names as $locale => $name){
            $this->names[$locale] = (string)$name;
        }
    }

    /**
     * @param string $locale
     * @return string
     */
    function getName($locale)
    {
        return isset($this->names[$locale])
                ? $this->names[$locale]
                : '';
    }

    /**
     * @param \SimpleXMLElement $element
     * @return POI
     */
    public static function createFromXML(\SimpleXMLElement $element)
    {
        /** @var POI $poi */
        $poi = parent::createFromXML($element);
        $names = Utils::fetchChildAttributePairs($element, 'name', 'locale', 'text');
        $poi->setNames($names);

        return $poi;
    }


}