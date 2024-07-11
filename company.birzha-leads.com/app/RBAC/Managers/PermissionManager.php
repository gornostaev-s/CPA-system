<?php

namespace App\RBAC\Managers;

use App\RBAC\Handlers\CachePermissionHandler;

class PermissionManager
{
    private int $userId;

    public function __construct(
        private readonly CachePermissionHandler $permissionHandler
    )
    {
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function has(string $permissionName): bool
    {
        return in_array($permissionName, $this->permissionHandler->handle($this->userId));
    }
}