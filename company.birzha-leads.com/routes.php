<?php

use App\Controllers\Api\ChallengersController;
use App\Controllers\Api\ClientsController;
use App\Controllers\FunnelController;
use App\Controllers\StatController;
use App\Controllers\ZvonokController;
use App\Controllers\EmployersController;
use App\Controllers\HeadHunterController;
use App\Controllers\IndexController;
use App\Controllers\AuthController;
use App\Core\Router;
use App\Middlewares\AuthMiddleware;

$request = $_SERVER['REQUEST_URI'];

Router::route('/', [IndexController::class, 'index'], AuthMiddleware::class);
Router::route('/clients', [\App\Controllers\ClientsController::class, 'index'], AuthMiddleware::class);
Router::route('/funnel', [FunnelController::class, 'index'], AuthMiddleware::class);
Router::route('/import', [IndexController::class, 'importForm'], AuthMiddleware::class);
Router::route('/employers', [EmployersController::class, 'index'], AuthMiddleware::class);
Router::route('/import-process', [\App\Controllers\ClientsController::class, 'importAll'], AuthMiddleware::class);
Router::route('/skorozvon-integration', [ZvonokController::class, 'index'], AuthMiddleware::class);
Router::route('/stat', [StatController::class, 'index'], AuthMiddleware::class);
//Router::route('/test', [IndexController::class, 'test'], AuthMiddleware::class);
Router::route('/login', [AuthController::class, 'login']);
Router::route('/registration', [AuthController::class, 'registration']);
Router::route('/hh/callback', [HeadHunterController::class, 'callback']);
Router::route('/zvonok/callback', [ZvonokController::class, 'callback']);

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

/**
 * api employers
 */

Router::route('/v1/employers/update', [\App\Controllers\Api\EmployersController::class, 'update']);
Router::route('/v1/change-employer-password', [\App\Controllers\Api\EmployersController::class, 'changePassword']);

/**
 * api challengers
 */

//

Router::route('/v1/challengers/add', [ChallengersController::class, 'add']);
Router::route('/v1/challengers/update', [ChallengersController::class, 'update']);
Router::route('/v1/challengers/move', [ChallengersController::class, 'move']);

echo Router::execute($_SERVER['REQUEST_URI']);
?>