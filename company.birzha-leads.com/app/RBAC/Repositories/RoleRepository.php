<?php

namespace App\RBAC\Repositories;

use App\Core\BaseMapper;
use App\RBAC\Entities\Role;
use Generator;
use ReflectionException;

class RoleRepository
{
    public function __construct(
        private readonly BaseMapper $mapper
    )
    {
    }

    public function getUserRoleById(int $userId): ?Role
    {
        $res = $this->mapper->db->query("select r.id, name from roles r
    left join user_roles ur on r.id = ur.role_id
where ur.user_id = $userId")->fetch();

        return $this->prepareRole($res ?: null);

    }

    /**
     * @return Role[]
     * @throws ReflectionException
     */
    public function getAllRoles(): array
    {
        $res = $this->mapper->db->query("select * from roles")->fetchAll();

        return $this->prepareRes($res);
    }

    /**
     * @param array|null $res
     * @return Role[]
     * @throws ReflectionException
     */
    private function prepareRes(?array $res): array
    {
        $items = [];
        foreach ($res as $item) {
            $items[] = $this->prepareRole($item);
        }

        return $items;
    }

    /**
     * @param array|null $queryRes
     * @return Role|null
     * @throws ReflectionException
     */
    private function prepareRole(?array $queryRes): ?Role
    {
        if (empty($queryRes)) {
            return null;
        }

        $e = new Role();
        $e->load($queryRes);

        return $e;
    }
}