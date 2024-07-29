<?php

use App\Controllers\Api\ChallengersController;
use App\Controllers\Api\ClientsController;
use App\Controllers\CommandsController;
use App\Controllers\FunnelController;
use App\Controllers\Api\RBAC\UserRolesController;
use App\Controllers\StatController;
use App\Controllers\ZvonokController;
use App\Controllers\EmployersController;
use App\Controllers\HeadHunterController;
use App\Controllers\IndexController;
use App\Controllers\AuthController;
use App\Core\Router;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\PermissionMiddleware;

$request = $_SERVER['REQUEST_URI'];

Router::route('/', [\App\Controllers\ClientsController::class, 'index'], PermissionMiddleware::class);
Router::route('/alfa', [\App\Controllers\ClientsController::class, 'alfa'], PermissionMiddleware::class);
Router::route('/sber', [\App\Controllers\ClientsController::class, 'sber'], PermissionMiddleware::class);
Router::route('/tinkoff', [\App\Controllers\ClientsController::class, 'tinkoff'], PermissionMiddleware::class);
//Router::route('/clients', [\App\Controllers\ClientsController::class, 'index'], AuthMiddleware::class);
Router::route('/funnel', [FunnelController::class, 'index'], PermissionMiddleware::class);
Router::route('/import', [IndexController::class, 'importForm'], PermissionMiddleware::class);
Router::route('/employers', [EmployersController::class, 'index'], PermissionMiddleware::class);
Router::route('/import-process', [IndexController::class, 'importFull'], PermissionMiddleware::class);
Router::route('/update-bills-process', [IndexController::class, 'updateFull'], PermissionMiddleware::class);
Router::route('/skorozvon-integration', [ZvonokController::class, 'index'], PermissionMiddleware::class);
Router::route('/stat', [StatController::class, 'index'], PermissionMiddleware::class);
//Router::route('/test', [IndexController::class, 'test'], AuthMiddleware::class);
Router::route('/login', [AuthController::class, 'login']);
Router::route('/registration', [AuthController::class, 'registration']);
Router::route('/hh/callback', [HeadHunterController::class, 'callback']);
Router::route('/zvonok/callback', [ZvonokController::class, 'callback']);
Router::route('/commands', [CommandsController::class, 'index'], PermissionMiddleware::class);

/**
 * RBAC
 */

Router::route('/user-roles', [App\Controllers\RBAC\UserRolesController::class, 'index']);

/**
 * Api routes
 */

Router::route('/v1/login', [\App\Controllers\Api\AuthController::class, 'login']);
Router::route('/v1/register', [\App\Controllers\Api\AuthController::class, 'register']);
Router::route('/v1/logout', [\App\Controllers\Api\AuthController::class, 'logout']);

/**
 * api clients
 */

Router::route('/v1/clients/update', [ClientsController::class, 'update']);
Router::route('/v1/clients/add', [ClientsController::class, 'add']);
Router::route('/v1/clients/delete', [ClientsController::class, 'delete']);
Router::route('/v1/clients/', [ClientsController::class, 'index']);

/**
 * api commands
 */

Router::route('/v1/commands/add', [ClientsController::class, 'add']);
Router::route('/v1/commands/update', [ClientsController::class, 'update']);

/**
 * api employers
 */

Router::route('/v1/employers/update', [\App\Controllers\Api\EmployersController::class, 'update']);
Router::route('/v1/change-employer-password', [\App\Controllers\Api\EmployersController::class, 'changePassword']);

/**
 * api challengers
 */

Router::route('/v1/challengers/add', [ChallengersController::class, 'add']);
Router::route('/v1/challengers/delete', [ChallengersController::class, 'delete']);
Router::route('/v1/challengers/update', [ChallengersController::class, 'update']);
Router::route('/v1/challengers/move', [ChallengersController::class, 'move']);

/**
 * api RBAC
 */

Router::route('/v1/rbac/users/update', [UserRolesController::class, 'update']);

echo Router::execute($_SERVER['REQUEST_URI']);
?>