<?php
namespace RealPadConnector\CMS\Project;

use RealPadConnector\Object;
use RealPadConnector\Utils;

class FlatAttribute extends Object {

    /**
     * @var array
     */
    protected $names = array();

    /**
     * @var array[]
     */
    protected $value_options = array();

    /**
     * @return string
     */
    function getKey()
    {
        return (string)$this['key'];
    }

    /**
     * @return int
     */
    function getType()
    {
        return (int)$this['type'];
    }

    /**
     * @return bool
     */
    function isRequired()
    {
        return (bool)$this['required'];
    }

    /**
     * @return bool
     */
    function isFilterable()
    {
        return (bool)$this['filterable'];
    }


    /**
     * @return bool
     */
    function showInPriceList()
    {
        return (bool)$this['show-in-pricelist'];
    }

    /**
     * @return int
     */
    function getPriceListPriority()
    {
        return (int)$this['pricelist-priority'];
    }

    /**
     * @return bool
     */
    function showInDetail()
    {
        return (bool)$this['show-in-detail'];
    }

    /**
     * @return int
     */
    function getDetailPriority()
    {
        return (int)$this['detail-priority'];
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
     * @param array $labels
     * @param mixed $value
     */
    function addValueOption(array $labels, $value)
    {
       foreach($labels as $locale => $label){
           if(!isset($this->value_options[$locale])){
               $this->value_options[$locale] = array();
           }
           $this->value_options[$locale][$value] = $label;
       }
    }

    /**
     * @param string $locale [optional]
     * @return array|array[]
     */
    function getValueOptions($locale = null)
    {
        if(!$locale){
            return $this->value_options;
        }

        return isset($this->value_options[$locale])
                ? $this->value_options[$locale]
                : array();
    }

    /**
     * @param \SimpleXMLElement $element
     * @return FlatAttribute
     */
    public static function createFromXML(\SimpleXMLElement $element)
    {
        /** @var FlatAttribute $flat_attribute */
        $flat_attribute = parent::createFromXML($element);
        $names = Utils::fetchChildAttributePairs($element, 'name', 'locale', 'text');
        $flat_attribute->setNames($names);

        if(isset($element->enum)){
            foreach($element->enum as $enum_element){
                $labels = Utils::fetchChildAttributePairs($enum_element, 'label', 'locale', 'text');
                $value = Utils::formatValueFromXML((string)$enum_element['value']);
                $flat_attribute->addValueOption($labels, $value);
            }
        }

        return $flat_attribute;
    }


}