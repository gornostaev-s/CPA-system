<?php

use App\Console\Controllers\ChangeApiStatusController;
use App\Console\Controllers\CheckCompaniesController;
use App\Console\Controllers\ClientsRegistrationController;
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
Router::route('status-api-clients', [ChangeApiStatusController::class, 'index']);
Router::route('clients', [MigrateClientsController::class, 'index']);
Router::route('clients-registration-yesterday', [ClientsRegistrationController::class, 'yesterday']);
Router::route('clients-registration-today', [ClientsRegistrationController::class, 'today']);
Router::route('clients-registration-weekly', [ClientsRegistrationController::class, 'weekly']);
Router::route('test-companies', [CheckCompaniesController::class, 'test']);
Router::route('responses', [HeadHunterController::class, 'import']);
Router::route('test', [TestController::class, 'test']);

echo Router::execute($request);
?>