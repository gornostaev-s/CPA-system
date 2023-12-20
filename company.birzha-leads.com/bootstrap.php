<?php

use App\Bootstrap\BootstrapDatabase;
use App\Core\App;

$bootstrap = [
    PDO::class => BootstrapDatabase::execute(),
//    AmoCRMApiClient::class => BootstrapAmoClient::execute()
];

App::app();