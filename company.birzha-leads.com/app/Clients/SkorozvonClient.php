<?php

namespace App\Clients;

use Redis;
use RedisException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SkorozvonClient
{
    const RUNTIME_DIR = '/var/www/company.birzha-leads.com/runtime';
    private array $authData;

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly Redis $redis
    )
    {
    }

    public function setAuthData(string $username, string $apiKey, string $clientId, string $clientSecret): void
    {
        $this->authData = [
            "grant_type" => "password",
            "username" => $username,
            "api_key" => $apiKey,
            "client_id" => $clientId,
            "client_secret" => $clientSecret
        ];
    }

    /**
     * @param int $projectId
     * @param string $phone
     * @param string $name
     * @return int|null
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function addLead(int $projectId, string $phone, string $name = ''): ?int
    {
        $res = $this->client->request('POST', 'https://app.skorozvon.ru/api/v2/leads', [
            'body' => [
                "name" => $name,
                "phones" => $phone,
                "call_project_id" => $projectId
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getToken()
            ]
        ])->getContent();

        return json_decode($res, true)['id'] ?? null;
    }

    /**
     * @return string
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws RedisException
     */
    private function getToken(): string
    {
        $last_try = $this->redis->get($this->authData['username'] . '-TOKEN-LAST-TIME');
        $last_token = $this->redis->get($this->authData['username'] . '-TOKEN-LAST');

        $cur_time = time();

        if ($last_token !== false && $last_try !== false) {
            if ($last_token != "" && $last_try != "") {
                if (($cur_time - intval($last_try)) < 10) {
                    return $last_token;
                }
            }
        }
        $this->prepareToken();

        return $this->getToken();
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
            'body' => $this->authData
        ])->getContent();

        $res = json_decode($res, true);

        $this->redis->set($this->authData['username'] . '-TOKEN-LAST-TIME', time());
        $this->redis->set($this->authData['username'] . '-TOKEN-LAST', $res['access_token']);
    }
}