<?php

namespace Robtesch\Watsontts;

use Robtesch\Watsontts\Exceptions\ValidationException;
use Robtesch\Watsontts\Models\CustomModel;
use Robtesch\Watsontts\Models\Synthesis;
use Robtesch\Watsontts\Models\Voice;

/**
 * Class Watsontts
 * @package Robtesch\Watsontts
 */
class Watsontts
{

    protected $client;
    protected $validator;

    /**
     * Watsontts constructor.
     * @param Client|null $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = is_null($client) ? new Client() : $client;
        $this->validator = new Validator();
    }

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getVoices()
    : array
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
    : Voice {
        $voice = $this->validator->validateVoiceName($voice);
        $response = $this->client->request('GET', 'voices/' . $voice);

        return new Voice($response);
    }

    /**
     * @param string       $method
     * @param string       $text
     * @param string|Voice $voice
     * @param string       $savePath
     * @param string       $accept
     * @param string|null  $customisationId
     * @return Synthesis
     * @throws ValidationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \wapmorgan\MediaFile\Exceptions\FileAccessException
     */
    public function synthesizeAudio(string $method, string $text, $voice, string $savePath, string $accept = null, string $customisationId = null)
    : Synthesis {
        $method = $this->validator->validateMethod($method);
        $voiceName = $this->validator->validateVoiceName($voice);
        $acceptString = $this->validator->validateAcceptTypes($savePath, $accept);
        $extension = $this->validator->getFileExtension($savePath, $acceptString, false);
        $sink = $savePath . $extension;
        $savePath = $this->validator->validatePath($sink);
        $queryData = [
            'accept' => $acceptString,
            'voice'  => $voiceName,
        ];
        if (!is_null($customisationId)) {
            $queryData['customization_id'] = $customisationId;
        }
        if ($method === 'GET') {
            $queryData['text'] = $text;
            $this->client->request('GET', 'synthesize', ['query' => $queryData, 'sink' => $savePath, 'headers' => ['Accept' => $accept]]);
        } else {
            $this->client->request('POST', 'synthesize', ['json' => ['text' => $text], 'query' => $queryData, 'sink' => $savePath, 'headers' => ['Accept' => $accept]]);
        }
        $mediaProcessor = new MediaProcessor();

        return $mediaProcessor->processFile($sink, $extension, $text, $voice, $customisationId);
    }

    /**
     * @param string       $text
     * @param string|Voice $voice
     * @param string|null  $format
     * @param string|null  $customisationId
     * @return string
     * @throws ValidationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPronunciation(string $text, $voice, string $format = null, string $customisationId = null)
    : string {
        $voice = $this->validator->validateVoiceName($voice);
        $format = $this->validator->validateFormat($format);
        $queryData = [
            'text'   => $text,
            'voice'  => $voice,
            'format' => $format,
        ];
        if (!is_null($customisationId)) {
            $queryData['customization_id'] = $customisationId;
        }
        $response = $this->client->request('GET', 'pronunciation', ['query' => $queryData]);

        return $response;
    }

    /**
     * @param string      $name
     * @param string|null $language
     * @param string|null $description
     * @return string
     * @throws ValidationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createCustomModel(string $name, string $language = null, string $description = null)
    {
        $jsonArray = [
            'name' => $name,
        ];
        if (!is_null($language)) {
            $language = $this->validator->validateLanguage($language);
            $jsonArray['language'] = $language;
        }
        if (!is_null($description)) {
            $jsonArray['description'] = $description;
        }
        $response = $this->client->request('POST', 'customizations', ['json' => $jsonArray]);

        return new CustomModel($response);
    }
}