<?php

namespace Robtesch\Watsontts;

use Illuminate\Support\Facades\Storage;
use Robtesch\Watsontts\Exceptions\ValidationException;
use Robtesch\Watsontts\Models\Synthesis;
use wapmorgan\MediaFile\MediaFile;

/**
 * Class MediaProcessor
 * @package Robtesch\Watsontts
 */
class MediaProcessor
{

    /**
     * @param string $path
     * @param string $extension
     * @param string $text
     * @param string $voice
     * @param null   $customisationId
     * @return Synthesis
     * @throws ValidationException
     * @throws \wapmorgan\MediaFile\Exceptions\FileAccessException
     */
    public function processFile(string $path, string $extension, string $text, string $voice, $customisationId = null)
    {
        $media = MediaFile::open($path);
        if ($media->isAudio()) {
            $audio = $media->getAudio();
            $length = $audio->getLength();
            $bitRate = $audio->getBitRate();
            $sampleRate = $audio->getSampleRate();
            $channels = $audio->getChannels();
        } else {
            throw new ValidationException('File is not a supported audio format', 422);
        }
        $pathRoot = config('filesystems.disks.' . config('watson-tts.filesystem', 'local') . '.root');
        $relativePath = substr($path, strlen($pathRoot));
        $size = Storage::size($relativePath);

        return new Synthesis([
            'extension'       => $extension,
            'size'            => $size,
            'length'          => $length,
            'bitRate'         => $bitRate,
            'sampleRate'      => $sampleRate,
            'channels'        => $channels,
            'text'            => $text,
            'voice'           => $voice,
            'customisationId' => $customisationId,
            'fullPath'        => $path,
            'relativePath'    => $relativePath,
        ]);
    }
}