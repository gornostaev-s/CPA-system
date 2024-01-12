<?php

namespace App\Clients;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HeadHunterClient
{
    public function __construct(
        private readonly HttpClientInterface $client,
    ) {
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
     */
    private function getOptions(): array
    {
        return [
            'headers' => [
                'Authorization' => 'Bearer USERHRAS8ATAAOM80M1AJHK0USQ0N85LITL2CDSAMH8409S3A8911C4C0BH6RGKC'
            ]
        ];
    }
}