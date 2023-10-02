<?php

namespace App\Provider;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TelegramProvider
{
    private string|int $recipientId;
    private string $botId;

    public function __construct(
        private readonly HttpClientInterface $client
    ) {
        $this->setBotId(getenv('TELEGRAM_ID'));
    }

    /**
     * @param string|int $recipientId
     * @return TelegramProvider
     */
    public function setRecipientId(string|int $recipientId): self
    {
        $this->recipientId = $recipientId;

        return $this;
    }

    /**
     * @param string $botId
     * @return void
     */
    private function setBotId(string $botId): void
    {
        $this->botId = $botId;
    }

    /**
     * @param string $message
     * @return void
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function sendMessage(string $message): void
    {
        $this->client->request('POST', $this->getEndpoint('sendMessage'), [
            'body' => [
                'chat_id' => $this->recipientId,
                'text' => $message,
                'parse_mode' => 'html'
                ]
            ]
        );
    }

    /**
     * @param string $method
     * @return string
     */
    public function getEndpoint(string $method): string
    {
        return "https://api.telegram.org/$this->botId/$method";
    }

    /**
     * Используется для установки вебхука
     *
     * @param string $url
     * @return void
     * @throws TransportExceptionInterface
     */
    public function setWebhook(string $url): void
    {
        $res = $this->client->request('POST', $this->getEndpoint('setWebhook'), [
                'body' => [
                    'url' => $url,
                ]
            ]
        );

        echo '<pre>';
        var_dump($res->getContent());
        die;
    }
}