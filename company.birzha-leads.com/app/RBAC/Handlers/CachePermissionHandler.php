<?php

namespace App\RBAC\Handlers;

use Redis;
use RedisException;

class CachePermissionHandler extends PermissionHandler
{
    const CACHE_KEY = 'permissions-';

    public function __construct(
        private readonly DatabasePermissionHandler $permissionHandler,
        private readonly Redis $redis,
    )
    {
        parent::__construct($this->permissionHandler::class);
    }

    /**
     * @throws RedisException
     */
    public function getPermissionsByUserId(int $userId): ?array
    {
        $permissions = $this->redis->get(self::CACHE_KEY . $userId);

        return !empty($permissions) ? json_decode($permissions, true) : null;
    }
}