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

#[AsCommand(name: 'page:create-template')]
class PageTemplateCommand extends Command
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
        $template = PageTemplate::make('Шаблон страницы продаж', 'sell.html.twig');

        $collection = new ArrayCollection([
            TextareaInput::make('content', 'Основной контент страницы'),
            TextInput::make('formTitle', 'Заголовок формы на странице'),
            TextInput::make('formDescription', 'Описание формы на странице'),
            TextInput::make('stepsTitle', 'Заголовок главного блока'),
            TextInput::make('stepsTitleIconOne', 'Заголовок первой иконки'),
            TextInput::make('stepsDescriptionIconOne', 'Описание первой иконки'),
            TextInput::make('stepsTitleIconTwo', 'Заголовок второй иконки'),
            TextInput::make('stepsDescriptionIconTwo', 'Описание второй иконки'),
            TextInput::make('stepsTitleIconThree', 'Заголовок третьей иконки'),
            TextInput::make('stepsDescriptionIconThree', 'Описание третьей иконки'),
            TextInput::make('stepsSubtitleOne', 'Подзаголовок первого шага'),
            TextInput::make('stepsTitleOne', 'Заголовок первого шага'),
            TextInput::make('stepsDescriptionOne', 'Описание первого шага'),
            TextInput::make('stepsLinkTextOne', 'Тест на кнопке'),
            TextInput::make('stepsLinkOne', 'Ссылка кнопки'),
            TextInput::make('stepsSubtitleTwo', 'Подзаголовок второго шага'),
            TextInput::make('stepsTitleTwo', 'Заголовок второго шага'),
            TextInput::make('stepsDescriptionTwo', 'Описание второго шага'),
            TextInput::make('stepsLinkTextTwo', 'Тест на кнопке'),
            TextInput::make('stepsLinkTwo', 'Ссылка кнопки'),
            TextInput::make('stepsSubtitleThree', 'Подзаголовок третьего шага'),
            TextInput::make('stepsTitleThree', 'Заголовок третьего шага'),
            TextInput::make('stepsDescriptionThree', 'Описание третьего шага'),
            TextInput::make('stepsLinkTextThree', 'Тест на кнопке'),
            TextInput::make('stepsLinkThree', 'Ссылка кнопки'),
        ]);

        $template->setFields($collection->map(function ($item) {
            return $this->serializer->normalize($item);
        })->toArray());

        $this->pageTemplateService->flush($template);

        return Command::SUCCESS;
    }
}