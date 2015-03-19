<?php
namespace RealPadConnector;

use Httpful\Mime;
use Httpful\Request;
use Httpful\Response;

class AbstractClient {

    const PRODUCTION_ENDPOINT = 'https://cms.realpad.eu/ws/v10/';
    const DEVELOPMENT_ENDPOINT = 'https://dev.realpad.eu/ws/v10/';

    const PARAM_LOGIN = 'login';
    const PARAM_PASSWORD = 'password';

    const SERVICE_GET_RESOURCE = 'get-resource';

    /**
     * @var string
     */
    protected $endpoint_url;

    /**
     * @var string
     */
    protected $login;

    /**
     * @var string
     */
    protected $password;

    /**
     * @param string $endpoint_url
     * @param string $login
     * @param string $password
     */
    public function __construct($endpoint_url, $login, $password)
    {
        $this->setEndpointUrl($endpoint_url);
        $this->setLogin($login);
        $this->setPassword($password);
    }


    /**
     * @param string $service_name
     * @param array $parameters [optional]
     * @return Request
     */
    public function createRequest($service_name, array $parameters = array())
    {
        $parameters['login'] = $this->getLogin();
        $parameters['password'] = $this->getPassword();
        //$query = http_build_query($parameters);

        $request = $this->initRequest($service_name);
        $request->body($parameters);

        return $request;
    }

    /**
     * @param string $service_name
     * @return Request
     */
    protected function initRequest($service_name)
    {
        $endpoint_url = $this->getEndpointUrl($service_name);
        return Request::post($endpoint_url)
            ->withoutStrictSsl()        // Ease up on some of the SSL checks
            ->sendsType(Mime::FORM);   // Send application/x-www-form-urlencoded

    }

    /**
     * @param string $service_name
     * @param array $parameters [optional]
     * @param null|Response $response [reference][optional]
     * @param bool $xml_expected
     * @return \SimpleXMLElement
     * @throws Exception
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function sendRequest($service_name, array $parameters = array(), &$response = null, $xml_expected = true)
    {
        $request = $this->createRequest($service_name, $parameters);
        //$request->expectsType(Mime::XML);

        /** @var Response $response */
        $response = @$request->send();
        switch($response->code){
            case 200:
                if($xml_expected && !$response->body instanceof \SimpleXMLElement){
                    throw new Exception("Invalid response data - SimpleXMLElement expected", Exception::CODE_INVALID_RESPONSE);
                }
                break;

            case 400:
                throw new Exception("Bad request", Exception::CODE_BAD_REQUEST);

            case 401:
                throw new Exception("Authentication failed", Exception::CODE_NOT_AUTHORIZED);

            case 418:
                throw new Exception("API version deprecated", Exception::CODE_API_VERSION_DEPRECATED);

            default:
                throw new Exception("Unsupported response code {$response->code}", Exception::CODE_INVALID_RESPONSE);
        }
        return $response->body;
    }

    /**
     * @param null|string $service_name [optional]
     * @return string
     */
    public function getEndpointUrl($service_name = null)
    {
        if(!$service_name){
            return $this->endpoint_url;
        }
        return $this->endpoint_url . $service_name;
    }

    /**
     * @param string $endpoint_url
     */
    public function setEndpointUrl($endpoint_url)
    {
        $this->endpoint_url = rtrim($endpoint_url, '/') . '/';
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = (string)$login;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = (string)$password;
    }

    /**
     * @param string $resource_ID
     * @param null|string $content_type [optional]
     * @return string
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getResourceData($resource_ID, &$content_type = null)
    {
        /** @var Response $response */
        $data = $this->sendRequest(
            self::SERVICE_GET_RESOURCE,
            array("uid" => $resource_ID),
            $response,
            false
        );

        $content_type = $response->content_type;
        return (string)$data;
    }

    /**
     * @param string $resource_ID
     * @param bool $exit [optional]
     */
    public function displayResource($resource_ID, $exit = true)
    {
        $data = $this->getResourceData($resource_ID, $content_type);
        header("Content-Type: {$content_type}");
        echo $data;
        if($exit){
            exit;
        }
    }


}