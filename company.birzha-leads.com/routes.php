<?php

use App\Controllers\Api\ClientsController;
use App\Controllers\HeadHunterController;
use App\Controllers\IndexController;
use App\Controllers\AuthController;
use App\Core\Router;
use App\Middlewares\AuthMiddleware;

$request = $_SERVER['REQUEST_URI'];

Router::route('/', [IndexController::class, 'index'], AuthMiddleware::class);
Router::route('/import', [IndexController::class, 'importForm']);
Router::route('/employers', [IndexController::class, 'importForm']);
Router::route('/import-process', [IndexController::class, 'import']);
Router::route('/hh/callback', [HeadHunterController::class, 'callback']);
Router::route('/test', [IndexController::class, 'test'], AuthMiddleware::class);
Router::route('/login', [AuthController::class, 'login']);
Router::route('/registration', [AuthController::class, 'registration']);

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

echo Router::execute($_SERVER['REQUEST_URI']);
?>