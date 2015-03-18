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
     * @return \SimpleXMLElement
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function sendRequest($service_name, array $parameters = array(), &$response = null)
    {
        $request = $this->createRequest($service_name, $parameters);
        /** @var Response $response */
        $response = $request->send();
        //todo: check body
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
     * @return array|object|string
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getResourceData($resource_ID, &$content_type = null)
    {
        $request = $this->createRequest('get-resource', array("uid" => $resource_ID));
        /** @var Response $response */
        $response = $request->send();
        //todo: check response
        $content_type = $response->content_type;

        return $response->body;
    }


}