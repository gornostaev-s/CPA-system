<?php

use App\Controllers\ExportController;
use App\Controllers\IndexController;
use App\Controllers\AuthController;
use App\Controllers\ApiController;
use App\Core\Router;

$request = $_SERVER['REQUEST_URI'];

Router::route('check-companies', [IndexController::class, 'index']);

echo Router::execute($_SERVER['REQUEST_URI']);
?>