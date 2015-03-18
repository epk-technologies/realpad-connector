<?php
namespace RealPadConnector\CMS\ListProjects;

use RealPadConnector\Object;
use RealPadConnector\Utils;

class ProjectSimple extends Object {

    /**
     * @var array
     */
    protected $locales = array();

    /**
     * @var array
     */
    protected $descriptions = array();

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
     * @return string
     */
    function getCity()
    {
        return (string)$this['city'];
    }

    /**
     * @return string
     */
    function getProjectGroup()
    {
        return (string)$this['project-group'];
    }

    /**
     * @return string
     */
    function getIconID()
    {
        return (string)$this['icon'];
    }

    /**
     * @return int
     */
    function getAvailableFlatCount()
    {
        return (int)$this['available-flat-count'];
    }

    /**
     * @return int
     */
    function getAvailableSecondMarketUnitCount()
    {
        return (int)$this['available-second-market-unit-count'];
    }

    /**
     * Array like ['en_US' => 'English', .... ]
     *
     * @param array $locales
     */
    function setLocales(array $locales)
    {
        $this->locales = array();
        foreach($locales as $locale => $label){
            $this->locales[$locale] = trim($label);
        }
    }

    /**
     * @return array
     */
    function getLocales()
    {
        return $this->locales;
    }

    /**
     * @param string $locale
     * @return bool
     */
    function hasLocale($locale)
    {
        return isset($this->locales[$locale]);
    }

    /**
     * @param string $locale
     * @return string
     */
    function getLocale($locale)
    {
        return isset($this->locales[$locale])
                ? $this->locales[$locale]
                : '';
    }

    /**
     * @return array
     */
    public function getDescriptions()
    {
        return $this->descriptions;
    }

    /**
     * Array like ['en_US' => 'Some description', .... ]
     *
     * @param array $descriptions
     */
    public function setDescriptions(array $descriptions)
    {
        $this->descriptions = array();
        foreach($descriptions as $locale => $description){
            $this->descriptions[$locale] = trim($description);
        }
    }

    /**
     * @param string $locale
     * @param bool $check_if_empty [optional]
     * @return bool
     */
    function hasDescription($locale, $check_if_empty = true)
    {
        if(!isset($this->descriptions[$locale])){
            return false;
        }

        if($check_if_empty && $this->descriptions[$locale] === ''){
            return false;
        }

        return true;
    }

    /**
     * @param string $locale
     * @return string
     */
    function getDescription($locale)
    {
        return isset($this->descriptions[$locale])
                ? $this->descriptions[$locale]
                : '';
    }

    /**
     * @param \SimpleXMLElement $element
     * @return ProjectSimple
     */
    public static function createFromXML(\SimpleXMLElement $element)
    {
        /** @var ProjectSimple $project */
        $project = parent::createFromXML($element);
        
        $locales = Utils::fetchChildAttributePairs($element, 'locale', 'iso', 'name');
        $project->setLocales($locales);

        $descriptions = Utils::fetchChildAttributePairs($element, 'description', 'locale', 'text');
        $project->setdescriptions($descriptions);

        return $project;
    }


}