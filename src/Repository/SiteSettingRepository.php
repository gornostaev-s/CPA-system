<?php

namespace App\Repository;

use App\Entity\SiteSetting;
use App\Entity\SiteSettingItem;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionClass;
use ReflectionException;

class SiteSettingRepository
{
    public function __construct(
        private readonly SiteSettingItemRepository $repository,
        private readonly EntityManagerInterface $entityManager
    )
    {

    }

    /**
     * @return SiteSetting
     * @throws ReflectionException
     */
    public function get(): SiteSetting
    {
        $e = SiteSetting::make();
        $this->setPropertiesFromDB($e);

        return $e;
    }

    /**
     * @throws ReflectionException
     */
    public function flush(SiteSetting $setting): void
    {
        $reflection = new ReflectionClass($setting::class);

        foreach ($reflection->getProperties() as $property) {
            if ($property->getName() == 'itemRepository') {
                continue;
            }

            $name = $property->getName();

            /**
             * @var SiteSettingItem $settingItem
             */
            $settingItem = $this->repository->findOneBy(['name' => $name]);

            if (empty($settingItem)) {
                $settingItem = SiteSettingItem::make($name, $setting->$name);
            } else {
                $settingItem->setValue($setting->$name);
            }

            $this->entityManager->persist($settingItem);
            $this->entityManager->flush();
        }
    }

    /**
     * Устанавливает свойства настроек сайта из базы данных.
     *
     * @param SiteSetting $setting
     * @return void
     * @throws ReflectionException
     */
    public function setPropertiesFromDB(SiteSetting $setting): void
    {
        $reflection = new ReflectionClass($setting::class);

        foreach ($reflection->getProperties() as $property) {
            if ($property->getName() == 'itemRepository') {
                continue;
            }

            $name = $property->getName();
            $setting->set($name, $this->repository->findOneBy(['name' => $name])?->getValue() ?? null);
        }
    }
}