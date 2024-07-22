<?php

namespace App\RBAC\Managers;

use App\Core\App;
use App\Core\Dispatcher;
use App\Helpers\AuthHelper;
use App\RBAC\Entities\Role;
use App\RBAC\Handlers\CachePermissionHandler;
use App\RBAC\Repositories\RoleRepository;
use Redis;
use RedisException;
use ReflectionException;

class PermissionManager
{
    private int $userId;

    /**
     * Синглтон
     *
     * @var PermissionManager|null
     */
    public static ?PermissionManager $self;

    /**
     * @return static
     * @throws ReflectionException
     */
    public static function getInstance(): self
    {
        if (empty(self::$self)) {
            self::$self = Dispatcher::dispatch(PermissionManager::class);
        }

        return self::$self;
    }

    public function __construct(
        private readonly CachePermissionHandler $permissionHandler,
        private readonly RoleRepository $roleRepository,
        private readonly Redis $redis
    )
    {
        $this->userId = (php_sapi_name() != 'cli') ? AuthHelper::getAuthUser()?->id : 0;
    }

    /**
     * @param int $userId
     * @return $this
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @param string $permissionName
     * @return bool
     * @throws ReflectionException
     */
    public function has(string $permissionName): bool
    {
        return in_array($permissionName, $this->permissionHandler->handle($this->userId));
    }

    /**
     * @param array $permissions
     * @return bool
     * @throws ReflectionException
     */
    public function hasPermissions(array $permissions): bool
    {
        $access = false;

        foreach ($permissions as $permission) {
            if (in_array($permission, $this->permissionHandler->handle($this->userId))) {
                $access = true;
                break;
            }
        }
        return $access;
    }

    /**
     * @param int|null $userId
     * @return Role|null
     */
    public function getUserRole(int $userId = null): ?Role
    {
        if (empty($userId)) {
            $userId = $this->userId;
        }

        return $this->roleRepository->getUserRoleById($userId);
    }

    /**
     * @param int|null $userId
     * @return void
     * @throws RedisException
     */
    public function flushPermissionsCache(?int $userId = null): void
    {
        if (!empty($userId)) {
            $this->redis->del(CachePermissionHandler::CACHE_KEY . $userId);
        } else {
            array_map(function ($key) {
                $this->redis->del($key);
            }, $this->redis->keys(CachePermissionHandler::CACHE_KEY . '*'));
        }
    }
}