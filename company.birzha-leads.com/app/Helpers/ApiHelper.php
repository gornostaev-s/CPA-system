<?php
namespace App\Helpers;

use App\Models\User;

/**
 * @class ApiHelper
 */
class ApiHelper
{
    public static function sendError($data)
    {
        header('Content-Type: application/json; charset=utf-8');

        return json_encode([
            'success' => false,
            'errors' => $data
        ]);
    }

    public static function sendSuccess($data)
    {
        header('Content-Type: application/json; charset=utf-8');

        return json_encode([
            'success' => true,
            'data' => $data
        ]);
    }

}
