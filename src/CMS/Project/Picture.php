<?php
namespace RealPadConnector\CMS\Project;

use RealPadConnector\Object;
use RealPadConnector\Utils;

class Picture extends Object {

    /**
     * @var array
     */
    protected $names = array();

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
     * @param bool $as_string [optional]
     * @param string $string_format [optional]
     * @return \DateTime|null|string
     */
    function getCreationTime($as_string = false, $string_format = 'Y-m-d H:i:s')
    {
        return Utils::formatDateTime($this['creation-time'], $as_string, $string_format);
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
     * @return Picture
     */
    public static function createFromXML(\SimpleXMLElement $element)
    {
        /** @var Picture $picture */
        $picture = parent::createFromXML($element);
        $names = Utils::fetchChildAttributePairs($element, 'name', 'locale', 'text');
        $picture->setNames($names);

        return $picture;
    }


}