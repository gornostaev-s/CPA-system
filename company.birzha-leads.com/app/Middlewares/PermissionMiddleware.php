<?php

namespace App\Middlewares;

use App\Helpers\AuthHelper;
use App\RBAC\Managers\PermissionManager;
use App\Utils\Exceptions\NotAuthorizedException;

class PermissionMiddleware extends AuthMiddleware
{
    public function __construct(
        private readonly AuthHelper $authHelper,
        private readonly PermissionManager $permissionManager
    )
    {
        parent::__construct($authHelper);
    }

    public function run(array $callback): void
    {
        parent::run($callback);

        $class = $callback[0];
        $method = $callback[1];

        if (!empty($class?->access[$method])) {
            $hasPermissions = $class?->access[$method];

            $access = false;
            foreach ($hasPermissions as $hasPermission) {
                $access = $this->permissionManager->has($hasPermission);
                if ($access) {
                    break;
                }
            }

            if (!$access) {
                throw new NotAuthorizedException('Вы не можете просматривать данную страницу', 403);
            }
        }
    }
}