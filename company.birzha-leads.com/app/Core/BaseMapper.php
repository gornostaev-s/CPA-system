<?php

namespace App\Core;

use App\Core\BaseEntity;
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
        $db = $this->db;

        try{
            $fields = $this->getTableFields($entity->getTableName());

            $data = [];

            foreach ($fields as $field) {
                if (!empty($entity->$field)) {
                    $data[$field] = $entity->$field;
                }
            }

            $db->beginTransaction();

            $keys = [];
            $values = [];

            foreach($data as $key => $value){
                $keys[] = "`$key`";
                $values[] = $db->quote($value);
            }

            $keys = '(' . implode(', ', $keys) . ')';
            $values = '(' . implode(', ', $values) . ')';
            $sql = self::$insertString . $entity->getTableName() . ' ' . $keys . ' VALUES ' . $values;

            $sth = $db->prepare($sql);
            $sth->execute();
            $id = $db->lastInsertId();
            $db->commit();

            return $id;

        } catch (\PDOException $e) {
            $transactionError = '';
            try {
                $db->rollback();
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
}