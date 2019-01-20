<?php

namespace Robtesch\Watsontts;

class Client {

    protected $endpoint;
    protected $apiVersion;
    protected $username;
    protected $password;

    public function __construct() {
        $this->endpoint = config('watson-tts.endpoint');
    }
}