<?php

namespace App\Repositories;

use App\Core\BaseMapper;
use App\Entities\Token;
use League\OAuth2\Client\Token\AccessToken;

class TokenRepository
{
    private $mapper;
    public function __construct(BaseMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function save(Token $token)
    {
        $token->expires = date('Y-m-d H:i:s', $token->expires);
        $this->mapper->save($token);
    }

    public function getLastToken()
    {
        $res = $this->mapper->db->query('SELECT * FROM tokens ORDER BY id DESC LIMIT 1')->fetch();
        $res['expires'] = strtotime($res['expires']);

        return Token::make($res);
    }

    public function createTableTokens(): bool
    {

    return $this->mapper->db->query("-- auto-generated definition
        create table tokens
            (
                id            int auto_increment
                primary key,
            access_token  text      null,
            refresh_token text      null,
            expires       timestamp null,
            base_domain   text      null
        )")->execute();
    }
}