<?php

namespace App\Service;

use App\Entity\SiteSetting;
use App\Repository\SiteSettingRepository;
use ReflectionException;

class SiteSettingService
{
    public function __construct(private readonly SiteSettingRepository $repository)
    {

    }

    /**
     * @return SiteSetting
     * @throws ReflectionException
     */
    public function get(): SiteSetting
    {
        return $this->repository->get();
    }

    /**
     * @param SiteSetting $setting
     * @return void
     * @throws ReflectionException
     */
    public function save(SiteSetting $setting): void
    {
        $this->repository->flush($setting);
    }
}