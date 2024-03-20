<?php

namespace App\Core;

class QueryBuilder
{
    private array $from;
    private array $select;
    private array $where;

    public function addFrom(string $from): void
    {
        $this->from[] = $from;
    }
    
    public function addSelect(array $select): void
    {
        $this->select = array_merge($this->select, $select);
    }

    public function addWhere(array $where): void
    {
        $this->where = array_merge($this->where, $where);
    }

    public function injectFilter($filter): void
    {
        $this->addWhere($filter->getFields());
    }

    public function getQuery()
    {
        $select = $this->prepareSelect();
        //"" SELECT field1, field2 FROM table1, table2 WHERE field1 = 'value1', field2 = 'value2'
    }

    private function prepareSelect(): string
    {
        return implode(',', $this->select);
    }
}