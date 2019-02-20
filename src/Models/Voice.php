<?php

namespace Robtesch\Watsontts\Models;

use Robtesch\Watsontts\Exceptions\ValidationException;

/**
 * Class Voice
 * @package Robtesch\Watsontts\Models
 */
class Voice
{

    protected $name;
    protected $language;
    protected $customizable;
    protected $gender;
    protected $url;
    protected $supportedFeatures;
    protected $description;

    /**
     * Voice constructor.
     * @param $properties
     */
    public function __construct($properties)
    {
        $this->name = $properties->name ?? null;
        $this->language = $properties->language ?? null;
        $this->customizable = $properties->customizable ?? false;
        $this->gender = $properties->gender ?? 'female';
        $this->url = $properties->url ?? null;
        $this->supportedFeatures = property_exists($properties, 'supported_features') ? new VoiceFeatures($properties->supported_features) : new VoiceFeatures();
        $this->description = $properties->description ?? null;
    }

    /**
     * @return null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return $this
     */
    public function setLanguage(string $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @param bool $customisable
     * @return $this
     */
    public function setCustomisable(bool $customisable)
    {
        $this->customizable = $customisable;

        return $this;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     * @return $this
     */
    public function setGender(string $gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return VoiceFeatures
     */
    public function getSupportedFeatures()
    {
        return $this->supportedFeatures;
    }

    /**
     * @param $supportedFeatures
     * @return $this
     * @throws \Exception
     */
    public function setSupportedFeatures($supportedFeatures)
    {
        if (is_array($supportedFeatures)) {
            $supportedFeatures = json_decode(json_encode($supportedFeatures));
        }
        if (is_object($supportedFeatures)) {
            $this->supportedFeatures = new VoiceFeatures($supportedFeatures);

            return $this;
        }
        throw new ValidationException('Supported Features must be either an array or object');
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }
}