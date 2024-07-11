<?php

namespace App\RBAC\Repositories;

use App\Core\BaseMapper;

class PermissionRepository
{
    public function __construct(
        private readonly BaseMapper $mapper
    )
    {
    }

    public function getUserPermissionsByUserId(int $userId): array
    {
        $res = $this->mapper->db->query("select name from permissions
            left join role_permissions rp on permissions.id = rp.permission_id
            left join user_roles ur on rp.role_id = ur.role_id
            where ur.user_id = $userId")->fetchAll();

        return $this->prepareRes($res) ?: [];
    }

    private function prepareRes(?array $res): ?array
    {
        return !empty($res) ? array_map(function ($value) {
            return $value['name'];
        }, $res) : null;
    }
}