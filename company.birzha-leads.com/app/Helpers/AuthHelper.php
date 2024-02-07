<?php
namespace App\Helpers;

use App\Helpers\UserHelper;
use App\Helpers\TokenHelper;

/**
 * @class AuthHelper
 */
class AuthHelper
{
    public static function isAuth(): bool|int
    {
        if(empty($_COOKIE['jwt'])){

            return false;
        }

        $token = $_COOKIE['jwt'];
        $data = TokenHelper::getDataByToken($token);

        if(
            (empty($data['IP']) && $data['IP'] != $_SERVER['REMOTE_ADDR']) ||
            empty($data['userId'])
        ){
            TokenHelper::deleteUserToken($token);

            return false;
        }

        $user = UserHelper::getUserById($data['userId']);
        $user = $user[0];

        if(empty($user) || $token != (string)$user['jwt'] || $token == '0'){
            TokenHelper::deleteUserToken($token);

            return false;
        }

        return true;
    }
}
