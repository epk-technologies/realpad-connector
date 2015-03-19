<?php
namespace RealPadConnector;

class Exception extends \Exception {

    const CODE_INVALID_RESPONSE = 999;
    const CODE_BAD_REQUEST = 400;
    const CODE_NOT_AUTHORIZED = 401;
    const CODE_API_VERSION_DEPRECATED = 418;


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