<?php

namespace Robtesch\Watsontts\Models;

use Robtesch\Watsontts\Exceptions\FileSystemException;
use Robtesch\Watsontts\Exceptions\ValidationException;

/**
 * Class Validator
 * @package Robtesch\Watsontts\Models
 */
class Validator
{

    /**
     * @param string $accept
     * @return string
     * @throws \Exception
     */
    public function validateAcceptTypes(string $accept)
    {
        $allowedAcceptTypes = [
            'audio/basic',
            'audio/flac',
            'audio/l16',
            'audio/ogg',
            'audio/ogg;codecs=opus',
            'audio/ogg;codecs=vorbis',
            'audio/mp3',
            'audio/mpeg',
            'audio/mulaw',
            'audio/wav',
            'audio/webm',
            'audio/webm;codecs=opus',
            'audio/webm;codecs=vorbis',
        ];
        if (!in_array($accept, $allowedAcceptTypes)) {
            throw new ValidationException('Accept type is not in allowed list of values. See https://cloud.ibm.com/docs/services/text-to-speech/http.html#format for a list of allowed values.', 422);
        }

        return $accept;
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
        $allowedVoices = [
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
        if (!in_array($voiceName, $allowedVoices)) {
            throw new ValidationException('Voice is not in allowed list of values. See https://cloud.ibm.com/apidocs/text-to-speech#get-a-voice for a list of allowed values.', 422);
        }

        return $voiceName;
    }
}