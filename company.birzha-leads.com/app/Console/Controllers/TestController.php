<?php

namespace App\Console\Controllers;

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
        echo '<pre>';
        var_dump($this->permissionManager->setUserId(1)->has('editUsers'));
        die;
    }
}