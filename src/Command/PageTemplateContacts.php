<?php

namespace App\Command;

use App\Entity\AdminInputs\TextareaInput;
use App\Entity\AdminInputs\TextInput;
use App\Entity\PageTemplate;
use App\Service\PageTemplateService;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(name: 'page:create-contacts-template')]
class PageTemplateContacts extends Command
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly PageTemplateService $pageTemplateService
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $template = PageTemplate::make('Шаблон страницы контактов', 'contacts.html.twig');

        $collection = new ArrayCollection([
            TextInput::make('phone', 'Телефон'),
            TextInput::make('jobTime', 'Время работы'),
            TextInput::make('address', 'Адрес'),
            TextInput::make('email', 'E-mail'),
            TextInput::make('telegram', 'Telegram'),
            TextInput::make('whatsapp', 'Whatsapp'),
            TextInput::make('mapLink', 'Ссылка на карту'),
        ]);

        $template->setFields($collection->map(function ($item) {
            return $this->serializer->normalize($item);
        })->toArray());

        $this->pageTemplateService->flush($template);

        return Command::SUCCESS;
    }
}