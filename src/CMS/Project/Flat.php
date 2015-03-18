<?php
namespace RealPadConnector\CMS\Project;

use RealPadConnector\Object;
use RealPadConnector\Utils;

class Flat extends Object {

    /**
     * @var Picture[]
     */
    protected $pictures = array();

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
     * @return string
     */
    function getPDFResourceID()
    {
        return (string)$this['pdf'];
    }

    /**
     * @return array|null
     */
    function getCoordinates()
    {
        return $this['coordinates'];
    }


    /**
     * @return Picture[]
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * @return bool
     */
    function hasPictures()
    {
        return (bool)$this->pictures;
    }

    /**
     * @return array
     */
    public function getPictureResourceIDs()
    {
        $output = array();
        foreach($this->pictures as $ID => $picture){
            $output[$ID] = $picture->getResourceID();
        }
        return $output;
    }

    /**
     * @param Picture[] $pictures
     */
    public function setPictures(array $pictures)
    {
        $this->pictures = array();
        foreach($pictures as $picture){
            $this->addPicture($picture);
        }
    }

    /**
     * @param Picture $picture
     */
    public function addPicture(Picture $picture)
    {
        $this->pictures[$picture->getID()] = $picture;
    }

    /**
     * @return null|Picture
     */
    public function getFirstPicture()
    {
        foreach($this->pictures as $picture){
            return $picture;
        }
        return null;
    }

    /**
     * @param int $ID
     * @return null|Picture
     */
    function getPicture($ID)
    {
        return isset($this->pictures[$ID])
                ? $this->pictures[$ID]
                : null;
    }


    /**
     * @param \SimpleXMLElement $element
     * @return Flat
     */
    public static function createFromXML(\SimpleXMLElement $element)
    {
        /** @var Flat $flat */
        $flat = parent::createFromXML($element);

        if(isset($element->picture)){
            foreach($element->picture as $picture_element)
            {
                $picture = Picture::createFromXML($picture_element);
                $flat->addPicture($picture);
            }
        }

        $attributes = Utils::fetchChildAttributePairs($element, 'flat-attribute', 'key', 'value');
        foreach($attributes as $attribute => $value){
            $flat->setParameter($attribute, $value);
        }

        return $flat;
    }
}