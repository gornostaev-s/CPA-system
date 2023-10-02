<?php

namespace App\Command;

use App\Entity\PageTemplate;
use App\Provider\TelegramProvider;
use App\Repository\UserRepository;
use App\Service\PageTemplateService;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Factory\UuidFactory;
use Symfony\Component\Uid\Uuid;

#[AsCommand(name: 'telegram:set-webhook')]
class TelegramSetWebhookCommand extends Command
{
    public const WEBHOOK = 'https://birzha-leads.com/tg-bot';

    public function __construct(
        private readonly TelegramProvider $telegramProvider,
        private readonly UuidFactory $uuidFactory,
        private readonly UserRepository $userRepository
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $users = $this->userRepository->findAll();

        foreach ($users as $user) {
            $user->setTelegramKey($this->uuidFactory->create()->getNode());
            $this->userRepository->save($user);
        }

        die;
        $this->telegramProvider->setWebhook(self::WEBHOOK);

        return Command::SUCCESS;
    }
}