<?php

namespace Robtesch\Watsontts\Models;

/**
 * Class VoiceFeatures
 * @package Robtesch\Watsontts\Models
 */
class VoiceFeatures
{

    protected $voiceTransformation;
    protected $customPronunciation;

    /**
     * VoiceFeatures constructor.
     * @param null $properties
     */
    public function __construct($properties = null)
    {
        $this->voiceTransformation = $properties->voice_transformation ?? false;
        $this->customPronunciation = $properties->custom_pronunciation ?? false;
    }
}