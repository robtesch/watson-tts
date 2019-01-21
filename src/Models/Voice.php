<?php
class Voice {

    protected $name;
    protected $language;
    protected $customizable;
    protected $gender;
    protected $url;
    protected $supportedFeatures;
    protected $description;

    public function __construct($properties) {
        $this->name = $properties->name ?? null;
        $this->language = $properties->name ?? null;
        $this->customizable = $properties->name ?? null;
        $this->gender = $properties->name ?? null;
        $this->url = $properties->name ?? null;
        $this->supportedFeatures = property_exists($properties, 'supported_features') ? new VoiceFeatures($properties->supportedFeatures) : new VoiceFeatures();
        $this->description = $properties->description ?? null;
    }
}