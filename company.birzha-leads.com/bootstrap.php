<?php

use App\Bootstrap\BootstrapDatabase;
use App\Bootstrap\BootstrapHttpClient;
use App\Core\App;
use Symfony\Contracts\HttpClient\HttpClientInterface;

$bootstrap = [
    PDO::class => BootstrapDatabase::execute(),
    HttpClientInterface::class => BootstrapHttpClient::execute()
];

App::app();