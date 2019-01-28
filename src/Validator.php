<?php

namespace Robtesch\Watsontts;

use Robtesch\Watsontts\Exceptions\FileSystemException;
use Robtesch\Watsontts\Exceptions\ValidationException;

/**
 * Class Validator
 * @package Robtesch\Watsontts
 */
class Validator
{

    const FILE_EXTENSIONS = [
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
    const ALLOWED_VOICES  = [
        'en-US_AllisonVoice',
        'en-US_LisaVoice',
        'en-US_MichaelVoice',
        'en-GB_KateVoice',
        'es-ES_EnriqueVoice',
        'es-ES_LauraVoice',
        'es-LA_SofiaVoice',
        'es-US_SofiaVoice',
        'de-DE_DieterVoice',
        'de-DE_BirgitVoice',
        'fr-FR_ReneeVoice',
        'it-IT_FrancescaVoice',
        'ja-JP_EmiVoice',
        'pt-BR_IsabelaVoice',
    ];

    /**
     * @param string $savePath
     * @param string $accept
     * @return string
     * @throws ValidationException
     */
    public function validateAcceptTypes(string $savePath, string $accept)
    {
        if (is_null($accept)) {
            foreach (self::FILE_EXTENSIONS as $key => $extension) {
                if ($this->stringEndsWith($savePath, $extension)) {
                    return $key;
                }
            }
        }
        if (!in_array($accept, array_keys(self::FILE_EXTENSIONS))) {
            throw new ValidationException('Accept type is not in allowed list of values. See https://cloud.ibm.com/docs/services/text-to-speech/http.html#format for a list of allowed values.', 422);
        }

        return $accept;
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    public function stringEndsWith(string $haystack, string $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, ($length * -1)) === $needle);
    }

    /**
     * @param string $path
     * @return string
     * @throws \Exception
     */
    public function validatePath(string $path)
    {
        if (file_exists($path)) {
            throw new FileSystemException('File already exists. Please use a different file name.', 422);
        }
        if (!is_writable(dirname($path))) {
            throw new FileSystemException('Path provided is not writable!', 422);
        }

        return $path;
    }

    /**
     * @param string $voiceName
     * @return string
     * @throws \Exception
     */
    public function validateVoiceName(string $voiceName)
    {
        if (!in_array($voiceName, self::ALLOWED_VOICES)) {
            throw new ValidationException('Voice is not in allowed list of values. See https://cloud.ibm.com/apidocs/text-to-speech#get-a-voice for a list of allowed values.', 422);
        }

        return $voiceName;
    }
}