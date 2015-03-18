<?php
namespace RealPadConnector\CMS;

use RealPadConnector\CMS\ListProjects\ProjectSimple;

use RealPadConnector\CMS\Project\Building;
use RealPadConnector\CMS\Project\Flat;
use RealPadConnector\CMS\Project\FlatAttribute;
use RealPadConnector\CMS\Project\Floor;
use RealPadConnector\CMS\Project\Gallery;
use RealPadConnector\CMS\Project\Picture;
use RealPadConnector\CMS\Project\POI;
use RealPadConnector\Utils;

class Project extends ProjectSimple implements \Iterator, \Countable {

    /**
     * @var array
     */
    protected $email_headers = array();

    /**
     * @var array
     */
    protected $emails = array();

    /**
     * @var array
     */
    protected $email_footers = array();


    /**
     * @var Building[]|Floor[][]|Flat[][][]
     */
    protected $buildings = array();

    /**
     * @var Gallery[]|Picture[][]
     */
    protected $galleries = array();
    
    /**
     * @var POI[]
     */
    protected $POIs = array();

    /**
     * @var FlatAttribute[]
     */
    protected $flat_attributes = array();


    /**
     * @param string $parameter
     * @param mixed $value
     */
    function setParameter($parameter, $value)
    {
        switch($parameter){
            case 'gps-center':
                $value = Utils::formatGPS($value);
                break;
            default:

        }
        parent::setParameter($parameter, $value);

    }


    /**
     * @return int
     */
    function getStage()
    {
        return $this['stage'];
    }

    /**
     * @return array|null
     */
    function getGPSCenter()
    {
        return $this['gps-center'];
    }

    /**
     * @return string
     */
    function getPlanResourceID()
    {
        return (string)$this['plan'];
    }

    /**
     * @return string
     */
    function getIconResourceID()
    {
        return (string)$this['icon'];
    }

    /**
     * @return string
     */
    function getStandardsResourceID()
    {
        return (string)$this['standards'];
    }


    /**
     * @return string
     */
    function getOfflineMapResourceID()
    {
        return (string)$this['offline-map'];
    }

    /**
     * @return bool
     */
    function isHypoAssistantEnabled()
    {
        return (bool)$this['hypo-assistant'];
    }

    /**
     * @return bool
     */
    function isPublic()
    {
        return (bool)$this['public'];
    }

    /**
     * @return bool
     */
    function isHidden()
    {
        return (bool)$this['hidden'];
    }

    /**
     * @return bool
     */
    function isDemo()
    {
        return (bool)$this['demo'];
    }

    /**
     * @return string
     */
    function getCurrency()
    {
        return (string)$this['currency'];
    }

    /**
     * @return Building[]
     */
    public function getBuildings()
    {
        return $this->buildings;
    }



    /**
     * @param Building[] $buildings
     */
    public function setBuildings(array $buildings)
    {
        $this->buildings = array();
        foreach($buildings as $building){
            $this->addBuilding($building);
        }
    }

    /**
     * @param Building $building
     */
    public function addBuilding(Building $building)
    {
        $this->buildings[$building->getID()] = $building;
    }

    /**
     * @param int $ID
     * @return null|Building
     */
    function getBuilding($ID)
    {
        return isset($this->buildings[$ID])
            ? $this->buildings[$ID]
            : null;
    }

    /**
     * @return Floor[]
     */
    function getFloors()
    {
        $output = array();
        foreach($this->buildings as $building){
            $output = array_merge($output, $building->getFloors());
        }
        return $output;
    }



    /**
     * @return Flat[]
     */
    function getFlats()
    {
        $output = array();
        foreach($this->buildings as $building){
            $output = array_merge($output, $building->getFlats());
        }
        return $output;
    }



    /**
     * @return Gallery[]
     */
    public function getGalleries()
    {
        return $this->galleries;
    }

    /**
     * @param Gallery[] $galleries
     */
    public function setGalleries(array $galleries)
    {
        $this->galleries = array();
        foreach($galleries as $gallery){
            $this->addGallery($gallery);
        }
    }

    /**
     * @param Gallery $gallery
     */
    public function addGallery(Gallery $gallery)
    {
        $this->galleries[$gallery->getID()] = $gallery;
    }

    /**
     * @param int $ID
     * @return null|Gallery
     */
    function getGallery($ID)
    {
        return isset($this->galleries[$ID])
            ? $this->galleries[$ID]
            : null;
    }

    /**
     * @return Picture[]
     */
    function getGalleriesPictures()
    {
        $output = array();
        foreach($this->galleries as $gallery){
            $output = array_merge($output, $gallery->getPictures());
        }
        return $output;
    }



    /**
     * @return POI[]
     */
    public function getPOIs()
    {
        return $this->POIs;
    }

    /**
     * @param POI[] $POIs
     */
    public function setPOIs(array $POIs)
    {
        $this->POIs = array();
        foreach($POIs as $POI){
            $this->addPOI($POI);
        }
    }

    /**
     * @param POI $POI
     */
    public function addPOI(POI $POI)
    {
        $this->POIs[$POI->getID()] = $POI;
    }

    /**
     * @param int $ID
     * @return null|POI
     */
    function getPOI($ID)
    {
        return isset($this->POIs[$ID])
            ? $this->POIs[$ID]
            : null;
    }



    /**
     * @return FlatAttribute[]
     */
    public function getFlatAttributes()
    {
        return $this->flat_attributes;
    }



    /**
     * @param FlatAttribute[] $flat_attributes
     */
    public function setFlatAttributes(array $flat_attributes)
    {
        $this->flat_attributes = array();
        foreach($flat_attributes as $flat_attribute){
            $this->addFlatAttribute($flat_attribute);
        }
    }

    /**
     * @param FlatAttribute $flat_attribute
     */
    public function addFlatAttribute(FlatAttribute $flat_attribute)
    {
        $this->flat_attributes[$flat_attribute->getKey()] = $flat_attribute;
    }

    /**
     * @param string $attribute
     * @return null|FlatAttribute
     */
    function getFlatAttribute($attribute)
    {
        return isset($this->flat_attributes[$attribute])
            ? $this->flat_attributes[$attribute]
            : null;
    }

    /**
     * @return array
     */
    public function getEmailHeaders()
    {
        return $this->email_headers;
    }

    /**
     * @param array $email_headers
     */
    public function setEmailHeaders(array $email_headers)
    {
        $this->email_headers = $email_headers;
    }

    /**
     * @return array
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * @param array $emails
     */
    public function setEmails(array $emails)
    {
        $this->emails = $emails;
    }

    /**
     * @return array
     */
    public function getEmailFooters()
    {
        return $this->email_footers;
    }

    /**
     * @param array $email_footers
     */
    public function setEmailFooters(array $email_footers)
    {
        $this->email_footers = $email_footers;
    }





    /**
     * @param \SimpleXMLElement $element
     * @return Project
     */
    public static function createFromXML(\SimpleXMLElement $element)
    {
        /** @var Project $project */
        $project = parent::createFromXML($element);

        if(isset($element->building)){
            foreach($element->building as $building_element)
            {
                $building = Building::createFromXML($building_element);
                $project->addBuilding($building);
            }
        }


        $project->email_headers = Utils::fetchChildAttributePairs($element, 'email-header', 'locale', 'text');
        $project->emails = Utils::fetchChildAttributePairs($element, 'email', 'locale', 'text');
        $project->email_footers = Utils::fetchChildAttributePairs($element, 'email-footer', 'locale', 'text');


        if(isset($element->gallery)){
            foreach($element->gallery as $gallery_element)
            {
                $gallery = Gallery::createFromXML($gallery_element);
                $project->addGallery($gallery);
            }
        }

        if(isset($element->poi)){
            foreach($element->poi as $poi_element) {
                $poi = POI::createFromXML($poi_element);
                $project->addPOI($poi);
            }
        }

        if(isset($element->{"flat-attribute-type"})){
            foreach($element->{"flat-attribute-type"} as $flat_attribute_element)
            {
                $flat_attribute = FlatAttribute::createFromXML($flat_attribute_element);
                $project->addFlatAttribute($flat_attribute);
            }
        }

        $attributes = Utils::fetchChildAttributePairs($element, 'project-attribute', 'key', 'value');
        foreach($attributes as $attribute => $value){
            $project->setParameter($attribute, $value);
        }


        return $project;
    }




    
    

    /**
     * @return Building|bool
     */
    public function current()
    {
        return current($this->buildings);
    }

    public function next()
    {
        next($this->buildings);
    }


    /**
     * @return int|null
     */
    public function key()
    {
        return key($this->buildings);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return key($this->buildings) !== null;
    }

    public function rewind()
    {
        reset($this->buildings);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->buildings);
    }
}