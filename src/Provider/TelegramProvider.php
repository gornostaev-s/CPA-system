<?php

namespace App\Provider;

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

    public function getEndpoint(string $method): string
    {
        return "https://api.telegram.org/$this->botId/$method";
    }
}