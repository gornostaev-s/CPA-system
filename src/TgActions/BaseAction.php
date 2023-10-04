<?php

namespace App\TgActions;

use App\Entity\TelegramSession;
use App\Provider\TelegramProvider;

abstract class BaseAction
{
    public function __construct(
        protected readonly TelegramProvider $telegramProvider
    )
    {
    }

    public static function getLastStep(): int|string|null
    {
        return array_key_last(static::$steps);
    }

    abstract public function execute(): void;
}