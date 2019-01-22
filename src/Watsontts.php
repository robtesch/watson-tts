<?php

namespace Robtesch\Watsontts;

use Robtesch\Watsontts\Models\Synthesis;
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
     * @param null   $customisationId
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \wapmorgan\MediaFile\Exceptions\FileAccessException
     */
    public function synthesizeAudioGet(string $text, $voice, string $savePath, string $accept = 'audio/ogg;codecs=opus', $customisationId = null)
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
        if (!is_null($customisationId)) {
            $queryData['customization_id'] = $customisationId;
        }
        $extension = $this->getFileExtension($acceptString, false);
        $sink = $savePath . $extension;
        $response = $this->client->request('GET', 'synthesize', ['query' => $queryData, 'sink' => $sink, 'headers' => ['Accept' => $accept]]);
        $mediaProcessor = new MediaProcessor();

        return $mediaProcessor->processFile($sink, $extension, $text, $voice, $customisationId);
    }

    /**
     * @param string $accept
     * @param bool   $validate
     * @return mixed
     * @throws \Exception
     */
    public function getFileExtension(string $accept, $validate = false)
    {
        if ($validate) {
            $accept = $this->validator->validateAcceptTypes($accept);
        }
        $fileExtensions = [
            'audio/basic'              => '.au',
            'audio/flac'               => '.flac',
            'audio/l16'                => '.l16',
            'audio/ogg'                => '.ogg',
            'audio/ogg;codecs=opus'    => '.opus',
            'audio/ogg;codecs=vorbis'  => '.ogg',
            'audio/mp3'                => '.mp3',
            'audio/mpeg'               => '.mpeg',
            'audio/mulaw'              => '.ulaw',
            'audio/wav'                => '.wav',
            'audio/webm'               => '.webm',
            'audio/webm;codecs=opus'   => '.webm',
            'audio/webm;codecs=vorbis' => '.webm',
        ];

        return $fileExtensions[$accept];
    }

    /**
     * @param string $text
     * @param        $voice
     * @param string $savePath
     * @param string $accept
     * @param null   $customisationId
     * @return Synthesis
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \wapmorgan\MediaFile\Exceptions\FileAccessException
     */
    public function synthesizeAudio(string $text, $voice, string $savePath, string $accept = 'audio/ogg;codecs=opus', $customisationId = null)
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
        if (!is_null($customisationId)) {
            $queryData['customization_id'] = $customisationId;
        }
        $extension = $this->getFileExtension($acceptString, false);
        $sink = $savePath . $extension;
        $response = $this->client->request('POST', 'synthesize', ['json' => ['text' => $text], 'query' => $queryData, 'sink' => $sink, 'headers' => ['Accept' => $accept]]);
        $mediaProcessor = new MediaProcessor();

        return $mediaProcessor->processFile($sink, $extension, $text, $voice, $customisationId);
    }
}