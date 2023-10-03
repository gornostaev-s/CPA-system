<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\IdTrait;
use App\Repository\TelegramSessionRepository;
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
}