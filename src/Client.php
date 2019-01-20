<?php

namespace Robtesch\Watsontts;

use GuzzleHttp\Client as GuzzleClient;

class Client extends GuzzleClient {

    protected $endpoint;
    protected $apiVersion;
    protected $username;
    protected $password;
    protected $client;

    /**
     * Client constructor.
     */
    public function __construct() {
        $this->endpoint = config('watson-tts.endpoint');
        $this->apiVersion = config('watson-tts.apiVersion');
        $this->username = config('watson-tts.username');
        $this->password = config('watson-tts.password');
        parent::__construct([
            'base_uri' => $this->endpoint . "/" . $this->apiVersion,
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
    public function request($method, $uri, array $options = []) {
        return json_decode(
            (string) parent::request($method, $uri, $options)->getBody()
        );
    }

    public function setEndpoint(string $endpoint) {
        $this->endpoint = $endpoint;

        return $this;
    }

    public function setApiVersion(string $apiVersion) {
        $this->apiVersion = $apiVersion;

        return $this;
    }

    public function setUsername(string $username) {
        $this->username = $username;

        return $this;
    }

    public function setPassword(string $password) {
        $this->password = $password;

        return $this;
    }
}