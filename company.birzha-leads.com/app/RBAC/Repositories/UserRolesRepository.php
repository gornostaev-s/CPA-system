<?php

namespace App\RBAC\Repositories;

use App\Core\BaseMapper;
use App\RBAC\Entities\UserRole;

class UserRolesRepository
{
    private BaseMapper $mapper;

    public function __construct(BaseMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function getUserRoleByUserId(int $userId): ?UserRole
    {
        $res = $this->mapper->db->query("SELECT id, user_id, role_id FROM user_roles
            WHERE user_id = $userId")->fetch();

        return $this->prepareRole($res ?: null);
    }

    private function prepareRole(?array $queryRes): ?UserRole
    {
        if (empty($queryRes)) {
            return null;
        }

        $e = new UserRole();
        $e->load($queryRes);

        return $e;
    }

    /**
     * @param UserRole $userRole
     * @return UserRole
     */
    public function save(UserRole $userRole): UserRole
    {
        $this->mapper->save($userRole);

        return $userRole;
    }
}