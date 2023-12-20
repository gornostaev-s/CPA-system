<?php

namespace App\Bootstrap;

use App\Core\BootstrapInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BootstrapHttpClient implements BootstrapInterface
{
    /**
     * @return HttpClientInterface
     */
    public static function execute(): HttpClientInterface
    {
        return HttpClient::create();
    }
}