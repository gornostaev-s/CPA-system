<?php

namespace App\RBAC\Handlers;

use App\RBAC\Repositories\PermissionRepository;
use RedisException;

class DatabasePermissionHandler extends PermissionHandler
{
    public function __construct(
        private readonly PermissionRepository $permissionRepository,
        private readonly \Redis $redis
    )
    {
        parent::__construct();
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getPermissionsByUserId(int $userId): array
    {
        $permissions = $this->permissionRepository->getUserPermissionsByUserId($userId);
        $this->toMemory($permissions, $userId);

        return $permissions;
    }

    /**
     * @throws RedisException
     */
    private function toMemory(array $permissions, int $userId)
    {
        $this->redis->set(CachePermissionHandler::CACHE_KEY . $userId, json_encode($permissions));
    }
}