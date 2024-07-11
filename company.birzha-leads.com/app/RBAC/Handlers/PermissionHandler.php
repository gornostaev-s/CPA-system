<?php

namespace App\RBAC\Handlers;

use App\Core\Container;
use App\Core\Dispatcher;
use ReflectionException;

abstract class PermissionHandler
{
    public function __construct(private readonly ?string $handlerClass = null)
    {
    }

    /**
     * @param int $userId
     * @return array
     * @throws ReflectionException
     */
    function handle(int $userId): array
    {
        $permissions = $this->getPermissionsByUserId($userId);

        if ($permissions === null && $this->handlerClass !== null) {
            /**
             * @var PermissionHandler $handler
             */
            $handler = Dispatcher::dispatch($this->handlerClass);
            $permissions = $handler->handle($userId);
        }

        return $permissions;
    }

    /**
     * @param int $userId
     * @return array|null
     */
    abstract function getPermissionsByUserId(int $userId): ?array;
}