<?php

class VoiceFeatures {
    protected $voiceTransformation;
    protected $customPronounciation;

    public function __construct($properties = null) {
        $this->voiceTransformation = $properties->voiceTransformation ?? false;
        $this->customPronounciation = $properties->customPronounciation ?? false;
    }
}