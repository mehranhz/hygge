<?php

namespace App\DTO\Response;


class BaseResponse
{
    private array $array = [];


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

