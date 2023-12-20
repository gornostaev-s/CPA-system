<?php

namespace App\Entities;

use App\Core\BaseEntity;

/**
 * @property int $id
 * @property string $access_token
 * @property string $refresh_token
 * @property string $expires
 * @property string $base_domain
 */
class Token extends BaseEntity
{
    public $id;
    public $access_token;
    public $refresh_token;
    public $expires;
    public $base_domain;

    public static function make(array $accessToken)
    {
        $token = new self;
        if (
            isset($accessToken['access_token'])
            && isset($accessToken['refresh_token'])
            && isset($accessToken['expires'])
            && isset($accessToken['base_domain'])
        ) {
            if (!empty($accessToken['id'])) {
                $token->id = $accessToken['id'];
            }
            $token->access_token = $accessToken['access_token'];
            $token->expires = $accessToken['expires'];
            $token->refresh_token = $accessToken['refresh_token'];
            $token->base_domain = $accessToken['base_domain'];

            return $token;
        } else {
            exit('Invalid access token ' . var_export($accessToken, true));
        }
    }
}