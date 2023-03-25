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
        $setting->set('publicPhone', $request->get('phone'));
        $setting->set('publicEmail', $request->get('email'));

        $this->repository->flush($setting);
    }
}