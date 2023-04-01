<?php

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

#[AsCommand(name: 'page:default-template')]
class PageTemplateDefaultCommand extends Command
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
        $template = PageTemplate::make('Шаблон обычной страницы', 'page.html.twig');

        $collection = new ArrayCollection([
            TextareaInput::make('content', 'Основной контент страницы'),
        ]);

        $template->setFields($collection->map(function ($item) {
            return $this->serializer->normalize($item);
        })->toArray());

        $this->pageTemplateService->flush($template);

        return Command::SUCCESS;
    }
}