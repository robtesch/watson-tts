<?php

namespace Robtesch\Watsontts;

use Voice;

class Watsontts {

    protected $client;

    public function __construct() {
        $this->client = new Client();
    }

    public function getVoices() {
        $response = $this->client->request('GET', 'voices');

        $voices = [];

        foreach($response->voices as $voiceData) {
            $voices[] = new Voice($voiceData);
        }

        return $voices;
    }
}