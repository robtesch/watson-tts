<?php

namespace Robtesch\Watsontts\Models;

/**
 * Class CustomModel
 * @package Robtesch\Watsontts\Models
 */
class CustomModel
{

    protected $customizationId;
    protected $name;
    protected $language;
    protected $owner;
    protected $created;
    protected $lastModified;
    protected $description;
    protected $words;

    /**
     * Synthesis constructor.
     * @param array|null $data
     */
    public function __construct(array $data = null)
    {
        $this->customizationId = $data['customizationId'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->language = $data['language'] ?? null;
        $this->owner = $data['owner'] ?? null;
        $this->created = $data['created'] ?? null;
        $this->lastModified = $data['lastModified'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->words = $data['words'] ?? [];
    }
}