<?php

namespace App\Core;

use PDO;

abstract class QueryBuilder
{
    private array $from = [];
    private array $group = [];
    private array $select = [];
    private array $where = [];
    private array $with = [];
    private array $join = [];
    private ?int $limit;
    private ?int $offset;

    public function __construct(
        private readonly PDO $db
    )
    {
    }

    protected function reset(): void
    {
        $this->from = [];
        $this->group = [];
        $this->select = [];
        $this->where = [];
        $this->with = [];
        $this->join = [];
        $this->limit = null;
        $this->offset = null;
    }

    /**
     * @param array $query
     * @return $this
     */
    public function addWith(array $query): self
    {
        $this->with = array_merge($this->with, $query);

        return $this;
    }

    /**
     * @param string $from
     * @return $this
     */
    public function addFrom(string $from): self
    {
        $this->from[] = $from;

        return $this;
    }

    /**
     * @param string $from
     * @return $this
     */
    public function addGroup(string $group): self
    {
        $this->group[] = $group;

        return $this;
    }

    /**
     * @param array $select
     * @return $this
     */
    public function addSelect(array $select): self
    {
        $this->select = array_merge($this->select, $select);

        return $this;
    }

    public function setSelect(array $select): self
    {
        $this->select = $select;

        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function addLimit(int $limit): static
    {
        $this->limit = $limit;

        return $this;
    }

    public function addOffset(int $offset): static
    {
        $this->offset = $offset;

        return $this;
    }

    public function setPage(int $page): void
    {
        $this->calculateOffsetByPage($page);
    }

    private function calculateOffsetByPage(int $page): void
    {
        $this->addOffset($this->limit * ($page - 1));
    }

    /**
     * @param array $where
     * @return $this
     */
    public function addWhere(array $where): self
    {
        $this->where = array_merge($this->where, $where);

        return $this;
    }

    /**
     * @param string $join
     * @return $this
     */
    public function addJoin(string $join): self
    {
        $this->join[] = $join;

        return $this;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return strtr('{with}SELECT {select} FROM {from} {join} {where} {group} {limit} {offset}', [
            '{with}' => $this->prepareWith(),
            '{select}' => $this->prepareSelect(),
            '{from}' => $this->prepareFrom(),
            '{join}' => $this->preapareJoin(),
            '{where}' => $this->prepareWhere(),
            '{group}' => $this->prepareGroup(),
            '{limit}' => $this->prepareLimit(),
            '{offset}' => $this->prepareOffset(),
        ]);
    }

    public function prepare($value): string
    {
        return $this->db->quote($value);
    }

    private function prepareLimit(): string
    {
        return !empty($this->limit) ? "LIMIT " . $this->limit : '';
    }

    private function prepareOffset(): string
    {
        return !empty($this->offset) ? "OFFSET " . $this->offset : '';
    }

    /**
     * @return string
     */
    private function preapareJoin(): string
    {
        return !empty($this->join) ? implode(' ', $this->join) : '';
    }

    /**
     * @return string
     */
    private function prepareWhere(): string
    {
        if (empty($this->where)) {

            return '';
        }

        $where = 'WHERE';

        $operator = 'AND';
        $i = 1;
        $count = count($this->where);

        foreach ($this->where as $key => $value) {
            if (is_int($key)) {
                $where .= " $value ";
            } else {
                $val = is_int($value) ? $value : $this->db->quote($value);
                $where .= "`$key`=" . $val;
            }
            if($i < $count){
                $where .= ' ' . $operator . ' ';
            }
            $i++;
        }

        return $where;
    }

    /**
     * @return string
     */
    private function prepareSelect(): string
    {
        return implode(', ', $this->select);
    }

    private function prepareGroup(): string
    {
        return !empty($this->group) ? "GROUP BY " . implode(', ', $this->group) : '';
    }

    /**
     * @return string
     */
    private function prepareWith(): string
    {
        if (empty($this->with)) {

            return '';
        }

        $with = 'WITH ';

        $i = 1;
        $count = count($this->with);

        foreach ($this->with as $key => $value) {
            $with .= "$key AS ($value)";
            if($i < $count){
                $with .= ', ';
            } else {
                $with.= ' ';
            }
            $i++;
        }

        return $with;
    }

    /**
     * @return string
     */
    private function prepareFrom(): string
    {
        return implode(',', $this->from);
    }
}