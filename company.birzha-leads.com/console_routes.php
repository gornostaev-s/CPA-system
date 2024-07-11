<?php

use App\Console\Controllers\CheckCompaniesController;
use App\Console\Controllers\HeadHunterController;
use App\Console\Controllers\MigrateClientsController;
use App\Console\Controllers\TestController;
use App\Controllers\ExportController;
use App\Controllers\IndexController;
use App\Controllers\AuthController;
use App\Controllers\ApiController;
use App\Core\Router;

$request = $argv[1];

Router::route('check-companies', [CheckCompaniesController::class, 'index']);
Router::route('clients', [MigrateClientsController::class, 'index']);
Router::route('test-companies', [CheckCompaniesController::class, 'test']);
Router::route('responses', [HeadHunterController::class, 'import']);
Router::route('test', [TestController::class, 'test']);

echo Router::execute($request);
?>