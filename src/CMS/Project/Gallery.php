<?php
namespace RealPadConnector\CMS\Project;

use RealPadConnector\Object;
use RealPadConnector\Utils;

class Gallery extends Object implements \Iterator, \Countable {

    /**
     * @var Picture[]
     */
    protected $pictures = array();

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
     * @param bool $as_string [optional]
     * @param string $string_format [optional]
     * @return \DateTime|null|string
     */
    function getCreationTime($as_string = false, $string_format = 'Y-m-d H:i:s')
    {
        return Utils::formatDateTime($this['creation-time'], $as_string, $string_format);

    }

    /**
     * @param bool $as_string [optional]
     * @param string $string_format [optional]
     * @return \DateTime|null|string
     */
    function getModificationTime($as_string = false, $string_format = 'Y-m-d H:i:s')
    {
        return Utils::formatDateTime($this['modification-time'], $as_string, $string_format);

    }

    /**
     * @return int
     */
    function getType()
    {
        return (int)$this['type'];
    }

    /**
     * @return Picture[]
     */
    public function getPictures()
    {
        return $this->pictures;
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
     * @return Gallery
     */
    public static function createFromXML(\SimpleXMLElement $element)
    {
        /** @var Gallery $gallery */
        $gallery = parent::createFromXML($element);

        if(isset($element->picture)){
            foreach($element->picture as $picture_element)
            {
                $picture = Picture::createFromXML($picture_element);
                $gallery->addPicture($picture);
            }
        }

        $gallery->names = Utils::fetchChildAttributePairs($element, 'name', 'locale', 'text');
        
        return $gallery;
    }



    /**
     * @return Picture
     */
    public function current()
    {
        return current($this->pictures);
    }

    public function next()
    {
        next($this->pictures);
    }


    /**
     * @return int|null
     */
    public function key()
    {
        return key($this->pictures);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return key($this->pictures) !== null;
    }

    public function rewind()
    {
        reset($this->pictures);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->pictures);
    }
}