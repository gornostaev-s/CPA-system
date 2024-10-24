<?php

namespace App\Helpers;

use App\Entities\AlfabankClient;
use App\Entities\PsbClient;
use App\Entities\SberbankClient;
use App\Entities\TinkoffClient;
use App\Entities\TochkaClient;

class BillsMapHelper
{
    const MAP = [
        AlfabankClient::class,
        TinkoffClient::class,
        SberbankClient::class,
        PsbClient::class,
        TochkaClient::class,
    ];
}