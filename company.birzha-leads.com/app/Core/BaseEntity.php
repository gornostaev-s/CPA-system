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
            $reflection = new ReflectionProperty($this, $key);

            match ($reflection->getType()->getName()) {
                'int' => $this->$key = (int)$propData,
                default => $this->$key = $propData,
            };
        }

        return $this;
    }
}