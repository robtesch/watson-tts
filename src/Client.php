<?php

namespace Robtesch\Watsontts;

use GuzzleHttp\Client as GuzzleClient;

class Client {

    protected $endpoint;
    protected $apiVersion;
    protected $username;
    protected $password;
    protected $client;

    public function __construct() {
        $this->endpoint = config('watson-tts.endpoint');
        $this->apiVersion = config('watson-tts.apiVersion');
        $this->username = config('watson-tts.username');
        $this->password = config('watson-tts.password');
        $this->client = new GuzzleClient([
            'base_uri' => $this->endpoint . "/" . $this->apiVersion,
            'auth' => [$this->username, $this->password]
        ]);
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

    public function getClient() {
        return $this->client;
    }
}