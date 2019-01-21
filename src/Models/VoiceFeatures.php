<?php

namespace Robtesch\Watsontts\Models;

/**
 * Class VoiceFeatures
 * @package Robtesch\Watsontts\Models
 */
class VoiceFeatures
{

    protected $voiceTransformation;
    protected $customPronounciation;

    /**
     * VoiceFeatures constructor.
     * @param null $properties
     */
    public function __construct($properties = null)
    {
        $this->voiceTransformation = $properties->voice_transformation ?? false;
        $this->customPronounciation = $properties->custom_pronunciation ?? false;
    }
}