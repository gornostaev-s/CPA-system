<?php

namespace App\TgActions;

use App\Entity\TelegramSession;

class ConnectAccountAction extends BaseAction
{
    const AUTH_STEP = 0;
    const VALIDATE_CODE = 1;
    const SUCCESS_STEP = 2;

    public static array $steps = [
        self::AUTH_STEP,
        self::VALIDATE_CODE,
        self::SUCCESS_STEP
    ];

    private TelegramSession $telegramSession;

    /**
     * @param TelegramSession $telegramSession
     */
    public function setTelegramSession(TelegramSession $telegramSession): void
    {
        $this->telegramSession = $telegramSession;
    }

    public function execute(): void
    {
        $this->telegramSession->setActionName(self::class);

        match ($this->telegramSession->getActionStep()) {
            default => $this->auth(),
            self::VALIDATE_CODE => $this->validate(),
            self::SUCCESS_STEP => $this->success(),
        };
    }

    public function auth()
    {
        $this->telegramProvider
            ->setRecipientId($this->telegramSession->getChatId())
            ->sendMessage('Для привязки аккаунта телеграм к Вашему профилю - 
            введите код указанный в настройках вашего профиля');

        $this->telegramSession->setActionStep(self::VALIDATE_CODE);
    }

    public function validate()
    {
        $this->telegramProvider
            ->setRecipientId($this->telegramSession->getChatId())
            ->sendMessage('Неверный код, пожалуйста, повторите еще раз.');
    }

    public function success()
    {
        
    }
}