<?php

namespace App\Services;

use App\Clients\HeadHunterClient;
use App\Clients\SkorozvonClient;
use Redis;
use RedisException;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class HeadHunterService
{
    public function __construct(
        private readonly HeadHunterClient $client,
        private readonly SkorozvonClient $skorozvonClient,
        private readonly Redis $redis
    )
    {
        $this->skorozvonClient->setAuthData(
            'nikoligurjanov@yandex.ru',
            '121de10d53de42fe1aa13999c0133d2e8d7ba0e33b553a52f899e1f5e4de33d4',
            '29055bf486467ffb99159edf3c21881d8ec4349ee1eb61c0b172364bbcc623b7',
            '172f48c27f7eb1c2322526b8f92d5b25dcc9cbc8785f137a428795b3f4a4cb2a'
        );
    }

    /**
     * Обработка запроса с колбек эндроинта hh ru
     *
     * @param array $queryData
     * @return void
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function apply(array $queryData): void
    {
        try {
            $resume = $this->getResumeDataById($queryData['payload']['resume_id']);
        } catch (ClientException $clientException) {
            if ($clientException->getCode() == 403) {
                $this->resetAuthToken();
                $resume = $this->getResumeDataById($queryData['payload']['resume_id']);
            }
        }
        $phone = $this->getPhoneByResume($resume);
        $name = $this->getNameByResume($resume);
//        $this->skorozvonClient->addLead(50000086198, $phone, "Отклик на hh.ru ($name)");
        $this->skorozvonClient->addLead(50000086198, $phone, "ТЕСТОВЫЙ ОТКЛИК ($name)");
    }

    /**
     * @param array $resume
     * @return string|null
     */
    private function getPhoneByResume(array $resume): ?string
    {
        return $resume['contact'][0]['value']['formatted'] ?? null;
    }

    /**
     * @param array $resume
     * @return string|null
     */
    private function getNameByResume(array $resume): ?string
    {
        return $resume['first_name'] ?? null;
    }

    /**
     * @param string $resumeId
     * @return array
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    private function getResumeDataById(string $resumeId): array
    {
        return $this->client->getResumeById($resumeId);
    }

    /**
     * @return void
     * @throws RedisException
     */
    private function resetAuthToken(): void
    {
        $queryData = $this->client->refreshToken($this->redis->get(HeadHunterClient::REFRESH_TOKEN_KEY));

        $this->redis->set(HeadHunterClient::ACCESS_TOKEN_KEY, $queryData['access_token']);
        $this->redis->set(HeadHunterClient::REFRESH_TOKEN_KEY, $queryData['refresh_token']);
        $this->redis->set(HeadHunterClient::EXPIRED_TIMESTAMP_KEY, time() + $queryData['expires_in']);
    }
}