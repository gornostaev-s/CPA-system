<?php

namespace App\Provider;

use App\Entity\TgButton;
use App\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TelegramClient
{
    private string|int $recipientId;
    private string $botId;
    private array $buttons;

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly Kernel $kernel
    ) {
    }

    /**
     * @param string|int $recipientId
     * @return TelegramClient
     */
    public function setRecipientId(string|int $recipientId): self
    {
        $this->recipientId = $recipientId;

        return $this;
    }

    /**
     * @param string $botId
     *
     * @return void
     */
    private function setBotId(string $botId): void
    {
        $this->botId = $botId;

    }

    /**
     * @param TgButton $tgButton
     * @param int|null $rowId
     * @return $this
     */
    public function setButton(TgButton $tgButton, ?int $rowId = null): self
    {
        if ($rowId) {
            $this->buttons[$rowId] = $tgButton->toArray();
        } else {
            $this->buttons[] = $tgButton->toArray();
        }

        return $this;
    }

    /**
     * @param string $message
     * @return void
     * @throws TransportExceptionInterface
     */
    public function sendMessage(string $message): void
    {
        $data = [
            'body' => [
                'chat_id' => $this->recipientId,
                'text' => $message,
                'parse_mode' => 'html'
            ]
        ];

        if (!empty($this->buttons)) {
            $data['reply_markup'] = [
                'inline_keyboard' => $this->buttons
            ];
        }

        $this->client->request('POST', $this->getEndpoint('sendMessage'), $data);
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
        $this->client->request('POST', $this->getEndpoint('setWebhook') . "?url=$url");
    }

    public function setRequestData(Request $request)
    {
        $dir = $this->kernel->getProjectDir();
        $tgPath = "$dir/var/tg";

        if (!is_dir($tgPath)) {
            mkdir($tgPath, recursive: true);
        }

        $content = $request->getContent();

        file_put_contents("$tgPath/req.txt", "\n $content \n");
    }
}