<?php

namespace App\Service;

use App\Entity\SiteSetting;
use App\Repository\SiteSettingRepository;
use ReflectionException;
use Symfony\Component\HttpFoundation\Request;

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
     * @param Request $request
     * @return void
     * @throws ReflectionException
     */
    public function save(SiteSetting $setting, Request $request): void
    {
        $setting->setPublicPhone($request->get('phone'));
        $setting->setPublicEmail($request->get('email'));
        $setting->setTelegram($request->get('telegram'));
        $setting->setAddress($request->get('address'));

        $this->repository->flush($setting);
    }
}