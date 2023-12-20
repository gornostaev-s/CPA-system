<?php

namespace App\Bootstrap;

use AmoCRM\Client\AmoCRMApiClient;
use App\Core\BootstrapInterface;

class BootstrapAmoClient implements BootstrapInterface
{
    private const CLIENT_ID = '49f30a47-d4d4-4eb6-928e-a9b69f7f7d1a';
    private const CLIENT_SECRET = 'mma1RYX2sD57csaPooOuY7tfgv98YAdWNgMPt9am8NqaASTgUoCTbVDUx5FfnTlf';
    private const CLIENT_REDIRECT_URI = 'http://urla-villa.ru/amocrm/feed/';

    /**
     * @return AmoCRMApiClient
     */
    public static function execute(): AmoCRMApiClient
    {
        return new AmoCRMApiClient(
            self::CLIENT_ID,
            self::CLIENT_SECRET,
            self::CLIENT_REDIRECT_URI);
    }
}