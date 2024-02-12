<?php

namespace App\DTO\Response;

use phpDocumentor\Reflection\Types\Self_;

class BaseResponse
{
    private array $array = [];

    public function __construct()
    {

    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $reflect = new \ReflectionClass($this);
        $attributes = $reflect->getProperties();

        foreach ($attributes as $attribute) {
            $propertyName = $attribute->getName();
            $this->array[$propertyName] = $this->$propertyName;
        }

        return $this->array;
    }
}

