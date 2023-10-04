<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\IdTrait;
use App\Repository\TelegramSessionRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TelegramSessionRepository::class)]
#[ORM\Table(name: 'telegram_session')]
class TelegramSession
{
    use IdTrait;
    use CreatedAtTrait;

    #[ORM\Column(name: 'user_id', type: 'integer', nullable: true)]
    private int $userId;

    #[ORM\Column(name: 'action_name', type: 'text', nullable: true)]
    private string $actionName;

    #[ORM\Column(name: 'action_step', type: 'integer', nullable: true)]
    private int $actionStep;

    #[ORM\Column(name: 'chat_id', type: 'integer', nullable: true)]
    private int $chatId;

    #[ORM\Column(name: 'last_message', type: 'text', nullable: true)]
    private string $lastMessage;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
    }

    public static function make(
        int $chatId,
    ): TelegramSession
    {
        $entity = new self;
        $entity->chatId = $chatId;

        return $entity;
    }

    /**
     * @return int
     */
    public function getChatId(): int
    {
        return $this->chatId;
    }

    /**
     * @param int $chatId
     */
    public function setChatId(int $chatId): void
    {
        $this->chatId = $chatId;
    }

    /**
     * @return string
     */
    public function getLastMessage(): string
    {
        return $this->lastMessage;
    }

    /**
     * @param string $lastMessage
     */
    public function setLastMessage(string $lastMessage): void
    {
        $this->lastMessage = $lastMessage;
    }

    /**
     * @return string
     */
    public function getActionName(): string
    {
        return $this->actionName;
    }

    /**
     * @param string $actionName
     */
    public function setActionName(string $actionName): void
    {
        $this->actionName = $actionName;
    }

    /**
     * @return int
     */
    public function getActionStep(): int
    {
        return $this->actionStep;
    }

    /**
     * @param int $actionStep
     */
    public function setActionStep(int $actionStep): void
    {
        $this->actionStep = $actionStep;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }
}