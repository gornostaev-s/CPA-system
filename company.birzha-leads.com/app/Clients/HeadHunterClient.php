<?php

namespace App\Clients;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HeadHunterClient
{
    const ACCESS_TOKEN_KEY = 'redis.accessToken';
    const REFRESH_TOKEN_KEY = 'redis.refreshToken';
    const EXPIRED_TIMESTAMP_KEY = 'redis.expiredTimestamp';

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly \Redis $redis
    ) {
    }

    public function refreshToken($refreshToken)
    {
        return json_decode($this
            ->client
            ->request('POST', 'https://hh.ru/oauth/token', $this->getOptions([
                'grant_type' => 'refresh_token',
                'refresh_token' => $refreshToken
            ]))
            ->getContent(), true);
    }

    /**
     * @param string $id
     * @return array
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getResumeById(string $id): array
    {
        return json_decode($this
            ->client
            ->request('GET', $this->getApiUrl('resumes') . "/$id/", $this->getOptions())
            ->getContent(), true);
    }

    /**
     * @param string $method
     * @return string
     */
    private function getApiUrl(string $method): string
    {
        return "https://api.hh.ru/$method";
    }

    /**
     * @return string[][]
     * @throws \RedisException
     */
    private function getOptions(?array $body = null): array
    {
        $options['headers'] = [
            'Authorization' => 'Bearer ' . $this->redis->get(self::ACCESS_TOKEN_KEY)
        ];

        if (!empty($body)) {
            $options['body'] = $body;
        }

        return $options;
    }
}