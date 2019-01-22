<?php

namespace Robtesch\Watsontts;

use GuzzleHttp\Client as GuzzleClient;

/**
 * Class Client
 * @package Robtesch\Watsontts
 */
class Client extends GuzzleClient
{

    protected $endpoint;
    protected $apiVersion;
    protected $username;
    protected $password;
    protected $client;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->endpoint = config('watson-tts.endpoint', 'https://stream.watsonplatform.net/text-to-speech/api');
        $this->apiVersion = config('watson-tts.api_version', 'v1');
        $this->username = config('watson-tts.username', '');
        $this->password = config('watson-tts.password', '');
        parent::__construct([
            'base_uri' => $this->endpoint . "/" . ltrim($this->apiVersion, "/") . "/",
            'auth'     => [$this->username, $this->password],
        ]);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $options
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($method, $uri = "", array $options = [])
    {
        $uri = ltrim($uri, "/");

        return json_decode((string)parent::request($method, $uri, $options)
                                         ->getBody());
    }

    /**
     * @param string $endpoint
     * @return $this
     */
    public function setEndpoint(string $endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * @param string $apiVersion
     * @return $this
     */
    public function setApiVersion(string $apiVersion)
    {
        $this->apiVersion = $apiVersion;

        return $this;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername(string $username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }
}