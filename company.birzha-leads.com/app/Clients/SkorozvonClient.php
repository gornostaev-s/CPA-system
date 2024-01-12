<?php

namespace App\Clients;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SkorozvonClient
{
    const RUNTIME_DIR = '/var/www/company.birzha-leads.com/runtime';

    public function __construct(
        private readonly HttpClientInterface $client
    )
    {
    }

    /**
     * @return void
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    private function prepareToken(): void
    {
        $res = $this->client->request('POST', 'https://app.skorozvon.ru/oauth/token', [
            'body' => [
                "grant_type" => "password",
                "username" => "nikoligurjanov@yandex.ru",
                "api_key" => "121de10d53de42fe1aa13999c0133d2e8d7ba0e33b553a52f899e1f5e4de33d4",
                "client_id" => "29055bf486467ffb99159edf3c21881d8ec4349ee1eb61c0b172364bbcc623b7",
                "client_secret" => "172f48c27f7eb1c2322526b8f92d5b25dcc9cbc8785f137a428795b3f4a4cb2a"
            ]
        ])->getContent();

        $res = json_decode($res, true);

        file_put_contents("../system/token.last.time", time());
        file_put_contents("../system/token.last", $res['access_token']);
    }

    /**
     * @return string
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getToken(): string
    {
        $last_try = file_get_contents(self::RUNTIME_DIR . "/token.last.time");
        $last_token = file_get_contents(self::RUNTIME_DIR . "/token.last");

        $cur_time = time();

        if ($last_token !== false && $last_try !== false) {
            if ($last_token != "" && $last_try != "") {
                if (($cur_time - intval($last_try)) < 500) {
                    return $last_token;
                }
            }
        }
        $this->prepareToken();

        return $this->getToken();
    }
}