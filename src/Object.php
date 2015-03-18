<?php
namespace RealPadConnector;

class Object implements \ArrayAccess, \JsonSerializable {

    /**
     * @var array
     */
    protected $parameters = array();

    /**
     * @param array|null $parameters [optional]
     */
    function __construct(array $parameters = null)
    {
        if($parameters){
            $this->setParameters($parameters);
        }
    }


    /**
     * @param \SimpleXMLElement $element
     * @return static
     */
    public static function createFromXML(\SimpleXMLElement $element)
    {
        $parameters = array();
        foreach($element->attributes() as $parameter => $value){
            $parameters[$parameter] = Utils::formatValueFromXML($value);
        }
        $instance = new static($parameters);
        return $instance;
    }




    /**
     * @param array $parameters
     */
    function setParameters(array $parameters)
    {
        foreach($parameters as $parameter => $value){
           $this->setParameter($parameter, $value);
        }
    }


    /**
     * @param string $parameter
     * @param mixed $value
     */
    function setParameter($parameter, $value)
    {
        $this->parameters[$parameter] = $value;
    }

    /**
     * @param string $parameter
     * @return bool
     */
    function hasParameter($parameter)
    {
        return isset($this->parameters[$parameter]);
    }

    /**
     * @param string $parameter
     */
    function removeParameter($parameter)
    {
        if(isset($this->parameters[$parameter])){
            unset($this->parameters[$parameter]);
        }    
    }

    /**
     * @param string $parameter
     * @param null|mixed $default_value [optional]
     * @return null|mixed
     */
    function getParameter($parameter, $default_value = null)
    {
        return isset($this->parameters[$parameter])
                ? $this->parameters[$parameter]
                : $default_value;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }



    /**
     * @param string $parameter
     * @return bool
     */
    public function offsetExists($parameter)
    {
        return $this->hasParameter($parameter);
    }

    /**
     * @param string $parameter
     * @return mixed|null
     */
    public function offsetGet($parameter)
    {
        return $this->getParameter($parameter);
    }

    /**
     * @param string $parameter
     * @param mixed $value
     */
    public function offsetSet($parameter, $value)
    {
        $this->setParameter($parameter, $value);
    }

    /**
     * @param string $parameter
     */
    public function offsetUnset($parameter)
    {
        $this->removeParameter($parameter);
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        $output = array();
        foreach(get_object_vars($this) as $param => $value){
            if($param[0] != '_'){
                $output[$param] = $value;
            }
        }
        return $output;
    }
}