<?php
namespace RealPadConnector;

class Exception extends \Exception {

    /**
     * @param string $message
     * @param int $code
     * @param \Exception $previous [optional]
     */
    public function __construct($message, $code, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }


}