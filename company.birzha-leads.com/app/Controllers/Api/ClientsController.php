<?php

namespace App\Controllers\Api;

use App\Core\Controller;
use App\Utils\ValidationUtil;

class ClientsController extends Controller
{
    public function update()
    {
        $request = ValidationUtil::validate($_POST,[
            "inn" => 'default',
            "fio" => 'default',
        ]);

        echo '<pre>';
        var_dump($request);
        die;
    }
}