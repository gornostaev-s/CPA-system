<?php

namespace App\Services;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Exceptions\InvalidArgumentException;
use AmoCRM\Models\CatalogElementModel;
use AmoCRM\OAuth2\Client\Provider\AmoCRMException;
use App\Entities\PropertyObject;
use App\Entities\Token;
use App\Repositories\TokenRepository;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;

class AmoCrmService
{
    const CATALOG_ID = 7307;

    private $client;
    /**
     * @var TokenRepository
     */
    private $tokenRepository;

    public function __construct(AmoCRMApiClient $client, TokenRepository $tokenRepository)
    {
        $this->client = $client;
        $this->tokenRepository = $tokenRepository;
        $this->setAppToken();
    }

    /**
     * @return array
     * @throws AmoCRMApiException
     * @throws AmoCRMMissedTokenException
     * @throws AmoCRMoAuthApiException
     * @throws InvalidArgumentException
     */
    public function getCatalogItems(): array
    {
        $items = $this->client->catalogElements(self::CATALOG_ID)->get();

        $objects = [];
        foreach ($items as $item) {
            /**
             * @var CatalogElementModel $item
             */
            $objects[] = PropertyObject::make($item);
        }

        return $objects;
    }

    public function setAppToken()
    {
        $token = $this->tokenRepository->getLastToken();
        $accessToken = new AccessToken([
            'access_token' => $token->access_token,
            'expires' => $token->expires,
            'base_domain' => $token->base_domain,
            'refresh_token' => $token->refresh_token
        ]);

        $this->client->setAccessToken($accessToken)
            ->setAccountBaseDomain('talguney.amocrm.ru')
            ->onAccessTokenRefresh(
                function (AccessTokenInterface $accessToken, string $baseDomain) {
                    $token = [
                        'access_token' => $accessToken->getToken(),
                        'refresh_token' => $accessToken->getRefreshToken(),
                        'expires' => $accessToken->getExpires(),
                        'base_domain' => $baseDomain,
                    ];

                    $token = Token::make($token);
                    $this->tokenRepository->save($token);
                }
            );
    }
}