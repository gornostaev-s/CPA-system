<?php

use App\Controllers\ExportController;
use App\Controllers\HeadHunterController;
use App\Controllers\IndexController;
use App\Controllers\AuthController;
use App\Controllers\ApiController;
use App\Core\Router;

$request = $_SERVER['REQUEST_URI'];

Router::route('/', [IndexController::class, 'index']);
Router::route('/import', [IndexController::class, 'importForm']);
Router::route('/import-process', [IndexController::class, 'import']);
Router::route('/hh/callback', [HeadHunterController::class, 'callback']);
//Router::route('/avito', [ExportController::class, 'avito']);
//Router::route('/tilda', [ExportController::class, 'tilda']);

echo Router::execute($_SERVER['REQUEST_URI']);
?>