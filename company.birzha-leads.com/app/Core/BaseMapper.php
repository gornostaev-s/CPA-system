<?php

namespace App\Core;

use App\Helpers\ApiHelper;
use PDO;

class BaseMapper
{
    private $query;
    private $orderString = ' ORDER BY ';
    private $pageString = ' LIMIT ';
    private $filterString = ' WHERE ';
    private static $insertString = 'INSERT INTO ';
    private static $updateString = 'UPDATE ';
    protected $table;
    protected $order;
    protected $join;
    protected $paging;
    protected $select = '*';
    protected $filter;
    const COUNT = 3;

    /**
     * @var PDO $db
     */
    public $db;
    
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(BaseEntity $entity)
    {
        try{
            $query = !empty($entity->id) ? $this->prepareUpdateQuery($entity) : $this->prepareInsertQuery($entity);

            $this->db->beginTransaction();
            $sth = $this->db->prepare($query);
            $sth->execute();
            $id = $this->db->lastInsertId();
            $this->db->commit();

            return $id;

        } catch (\PDOException $e) {
            $transactionError = '';
            try {
                $this->db->rollback();
            } catch (\PDOException $transactionError) {
                if ($transactionError->getMessage() != 'There is no active transaction') {
                    $transactionError = $transactionError->getMessage();
                }
            }

            echo ApiHelper::sendError([
                'error' => 'Во время добавления записи возникла ошибка.',
                'errorMessage' => $e->getMessage() (!empty($transactionError)) ? " $transactionError" : ''
            ]);
            die;
        }
    }

    public function getTableFields(string $tableName): array
    {
        $q = $this->db->prepare("DESCRIBE $tableName");
        $q->execute();
        return $q->fetchAll(PDO::FETCH_COLUMN);
    }

    private function prepareInsertQuery(BaseEntity $entity): string
    {
        $db = $this->db;
        $fields = $this->getTableFields($entity->getTableName());

        $data = [];

        foreach ($fields as $field) {
            if (!empty($entity->$field)) {
                $data[$field] = $entity->$field;
            }
        }

        $keys = [];
        $values = [];

        foreach($data as $key => $value){
            $keys[] = "`$key`";
            $values[] = $db->quote($value);
        }

        $keys = '(' . implode(', ', $keys) . ')';
        $values = '(' . implode(', ', $values) . ')';
        return self::$insertString . $entity->getTableName() . ' ' . $keys . ' VALUES ' . $values;
    }

    private function prepareUpdateQuery(BaseEntity $entity): string
    {
        $db = $this->db;
        $fields = $this->getTableFields($entity->getTableName());

        $data = [];

        foreach ($fields as $field) {
            if (!empty($entity->$field)) {
                $data[$field] = $entity->$field;
            }
        }

        $i = 1;
        $count = count($data);
        $fields = '';

        foreach ($data as $key => $value) {
            $fields .= "`$key`=" . $db->quote($value);
            if($i < $count){
                $fields .= ', ';
            }
            $i++;
        }

        return  self::$updateString . $entity->getTableName() . ' SET ' . $fields . 'WHERE `id`=' . $entity->id;
    }
}