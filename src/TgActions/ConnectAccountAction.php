<?php

namespace App\TgActions;

use App\Entity\TelegramSession;
use App\Provider\TelegramProvider;
use App\Repository\UserRepository;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

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

    public function __construct(
        private readonly UserRepository $userRepository,
        TelegramProvider $telegramProvider
    )
    {
        parent::__construct($telegramProvider);

    }

    /**
     * @param TelegramSession $telegramSession
     */
    public function setTelegramSession(TelegramSession $telegramSession): void
    {
        $this->telegramSession = $telegramSession;
    }

    /**
     * @return void
     * @throws TransportExceptionInterface
     */
    public function execute(): void
    {
        $this->telegramSession->setActionName(self::class);

        match ($this->telegramSession->getActionStep()) {
            default => $this->auth(),
            self::VALIDATE_CODE => $this->validate(),
            self::SUCCESS_STEP => $this->success(),
        };
    }

    /**
     * @return void
     * @throws TransportExceptionInterface
     */
    public function auth(): void
    {
        $this->telegramProvider
            ->setRecipientId($this->telegramSession->getChatId())
            ->sendMessage('Для привязки аккаунта телеграм к Вашему профилю - <br>введите код указанный в настройках вашего профиля');

        $this->telegramSession->setActionStep(self::VALIDATE_CODE);
    }

    /**
     * @return void
     * @throws TransportExceptionInterface
     */
    public function validate(): void
    {
        $user = $this->userRepository->findOneBy(['telegramKey' => $this->telegramSession->getLastMessage()]);

        if (!empty($user)) {
            $this->telegramSession->setUserId($user->getId());

            $this->telegramProvider
                ->setRecipientId($this->telegramSession->getChatId())
                ->sendMessage("Аккаунт пользователя {$user->getName()} привязан успешно");

            $this->telegramSession->setActionStep(self::SUCCESS_STEP);
        } else {
            $this->telegramProvider
                ->setRecipientId($this->telegramSession->getChatId())
                ->sendMessage('Неверный код, пожалуйста, повторите еще раз.');
        }
    }

    /**
     * @return void
     */
    public function success(): void
    {
        
    }
}