<?php
namespace RealPadConnector;

class Utils {

    /**
     * @param string|int|\DateTime $datetime
     * @param bool $as_string [optional]
     * @param string $string_format [optional]
     * @return \DateTime|null|string
     */
    public static function formatDateTime($datetime, $as_string = false, $string_format = 'Y-m-d H:i:s')
    {
        if(!$datetime){
            return null;
        }

        if(!$datetime instanceof \DateTime){
            if(is_numeric($datetime)){
                $datetime = new \DateTime("@{$datetime}");
            } else {
                $datetime = new \DateTime("{$datetime}");
            }
        }

        if(!$as_string){
            return $datetime;
        }

        return date($string_format, $datetime->getTimestamp());
    }

    /**
     * @param string|array $value
     * @return array|null
     */
    public static function formatGPS($value)
    {
        if(!is_array($value)){
            $value = trim($value);
            if(strpos($value, ',') === false){
                return null;
            }
            $value = explode(',', $value);
        }

        if(!isset($value[0], $value[1])){
            return null;
        }

        $value[0] = (float)$value[0];
        $value[1] = (float)$value[1];
        return $value;
    }

    /**
     * @param string|array $value
     * @return array|null
     */
    public static function formatCoordinates($value)
    {
        if(!is_array($value)){
            $value = trim($value);
            if(strpos($value, ',') === false){
                return null;
            }
            $value = explode(',', $value);
        }

        foreach($value as &$v){
            $v = (int)$v;
        }

        return $value;
    }

    /**
     * @param string $value
     * @return bool|float|int|mixed
     */
    public static function formatValueFromXML($value)
    {
        $value = (string)$value;
        if($value === 'true'){
            return true;
        }

        if($value === 'false'){
            return false;
        }

        if(is_numeric($value)){
            if(strpos($value, '.') !== false){
                return (float)$value;
            }
            return (int)$value;
        }

        return $value;
    }

    /**
     * @param \SimpleXMLElement $parent_element
     * @param string $node_name
     * @param string $key_attribute
     * @param string $value_attribute
     * @return array
     */
    public static function fetchChildAttributePairs(\SimpleXMLElement $parent_element, $node_name, $key_attribute, $value_attribute)
    {
        if(!isset($parent_element->{$node_name})){
            return array();
        }

        $values = array();
        foreach($parent_element->{$node_name} as $node){
            if(isset($node[$value_attribute])){
                $value = self::formatValueFromXML((string)$node[$value_attribute]);
            } else {
                $value = null;
            }
            $values[(string)$node[$key_attribute]] = $value;
        }

        return $values;
    }
}