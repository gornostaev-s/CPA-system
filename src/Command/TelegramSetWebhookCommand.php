<?php

namespace App\Command;

use App\Provider\TelegramProvider;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'telegram:set-webhook')]
class TelegramSetWebhookCommand extends Command
{
    public const WEBHOOK = 'https://birzha-leads.com/tg-bot';

    public function __construct(
        private readonly TelegramProvider $telegramProvider
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->telegramProvider->setWebhook(self::WEBHOOK);

        return Command::SUCCESS;
    }
}