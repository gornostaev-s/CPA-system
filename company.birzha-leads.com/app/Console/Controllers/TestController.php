<?php

namespace App\Console\Controllers;

use App\RBAC\Enums\PermissionsEnum;
use App\RBAC\Managers\PermissionManager;

class TestController
{
    public function __construct(
        private readonly PermissionManager $permissionManager
    )
    {
    }

    public function test()
    {
        $this->permissionManager->flushPermissionsCache();
    }
}