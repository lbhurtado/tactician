<?php

namespace LBHurtado\Tactician\Classes;

use LBHurtado\Tactician\Contracts\CommandInterface;

class CommandAbstract implements CommandInterface
{
    protected $properties;

    public function __construct(array $data)
    {
        $this->setPropertiesForValidation($data);
    }

    public function getProperties():array
    {
        return $this->properties;
    }

    public function setPropertiesForValidation($data)
    {
        foreach ($this->properties = $data as $property => $value) {
            $this->{$property} = $value;
        }
    }
}
