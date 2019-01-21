<?php

namespace Robtesch\Watsontts;

use Robtesch\Watsontts\Models\Validator;
use Robtesch\Watsontts\Models\Voice;

/**
 * Class Watsontts
 * @package Robtesch\Watsontts
 */
class Watsontts
{

    protected $client;
    protected $validator;

    public function __construct()
    {
        $this->client = new Client();
        $this->validator = new Validator();
    }

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getVoices()
    {
        $response = $this->client->request('GET', 'voices');
        $voices = [];
        foreach ($response->voices as $voiceData) {
            $voices[] = new Voice($voiceData);
        }

        return $voices;
    }

    /**
     * @param string $voice
     * @return Voice
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getVoice(string $voice)
    {
        $voice = $this->validator->validateVoiceName($voice);
        $response = $this->client->request('GET', 'voices/' . $voice);

        return new Voice($response);
    }

    /**
     * @param string $text
     * @param        $voice
     * @param string $savePath
     * @param string $accept
     * @param null   $customisation_id
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function synthesizeAudioGet(string $text, $voice, string $savePath, string $accept = 'audio/ogg;codecs=opus', $customisation_id = null)
    {
        if ($voice instanceof Voice) {
            $voice = $voice->getName();
        }
        $voiceName = $this->validator->validateVoiceName($voice);
        $acceptString = $this->validator->validateAcceptTypes($accept);
        $savePath = $this->validator->validatePath($savePath);
        $queryData = [
            'accept' => $acceptString,
            'text'   => $text,
            'voice'  => $voiceName,
        ];
        if (!is_null($customisation_id)) {
            $queryData['customization_id'] = $customisation_id;
        }
        $response = $this->client->request('GET', 'synthesize', ['query' => $queryData, 'sink' => $savePath, 'headers' => ['Accept' => $accept]]);

        return $savePath;
    }

    /**
     * @param string $text
     * @param        $voice
     * @param string $savePath
     * @param string $accept
     * @param null   $customisation_id
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function synthesizeAudio(string $text, $voice, string $savePath, string $accept = 'audio/ogg;codecs=opus', $customisation_id = null)
    {
        if ($voice instanceof Voice) {
            $voice = $voice->getName();
        }
        $voiceName = $this->validator->validateVoiceName($voice);
        $acceptString = $this->validator->validateAcceptTypes($accept);
        $savePath = $this->validator->validatePath($savePath);
        $queryData = [
            'accept' => $acceptString,
            'voice'  => $voiceName,
        ];
        if (!is_null($customisation_id)) {
            $queryData['customization_id'] = $customisation_id;
        }
        $response = $this->client->request('POST', 'synthesize', ['json' => ['text' => $text], 'query' => $queryData, 'sink' => $savePath, 'headers' => ['Accept' => $accept]]);

        return $savePath;
    }
}