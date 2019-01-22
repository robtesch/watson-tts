<?php

namespace Robtesch\Watsontts\Models;

/**
 * Class Synthesis
 * @package Robtesch\Watsontts\Models
 */
class Synthesis
{

    protected $extension;
    protected $size;
    protected $length;
    protected $bitRate;
    protected $sampleRate;
    protected $channels;
    protected $text;
    protected $voice;
    protected $customisationId;
    protected $path;

    /**
     * Synthesis constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->extension = $data['extension'];
        $this->size = $data['size'];
        $this->length = $data['length'];
        $this->bitRate = $data['bitRate'];
        $this->sampleRate = $data['sampleRate'];
        $this->channels = $data['channels'];
        $this->text = $data['text'];
        $this->voice = $data['voice'];
        $this->customisationId = $data['customisationId'];
        $this->path = $data['path'];
    }
}