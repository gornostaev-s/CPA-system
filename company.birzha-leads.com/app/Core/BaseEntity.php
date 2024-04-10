<?php

namespace App\Core;

use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

class BaseEntity
{
    /**
     * Возвращает название таблицы в базе данных в МНОЖЕСТВЕННОМ числе
     * К примеру если модель называется Order, данная конструкция вернет orders
     *
     * @return string
     */
    public function getTableName(): string
    {
        return strtolower((new ReflectionClass($this))->getShortName()) . 's';
    }

    /**
     * @throws ReflectionException
     */
    public function load(array $data): self
    {
        foreach ($data as $key => $propData) {
            try {
                $reflection = new ReflectionProperty($this, $key);
            } catch (ReflectionException $e) {
                continue;
            }

            match ($reflection->getType()->getName()) {
                'int' => $this->$key = (int)$propData,
                default => $this->$key = $propData,
            };
        }

        $this->setDefaults();

        return $this;
    }

    private function setDefaults()
    {
        $properties = (new ReflectionClass($this))->getProperties();

        foreach ($properties as $property) {
            $name = $property->getName();
            if (!isset($this->$name)) {
                if ($property->getType()->allowsNull()) {
                    $this->$name = null;
                    continue;
                }

                $this->$name = match ($property->getType()->getName()) {
                    'string' => '',
                    'int' => 0,
                    'boolean' => false,
                    default => null
                };
            }
        }
    }
}