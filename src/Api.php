<?php

namespace PushAll;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Api
{
    const API_URL = 'https://pushall.ru/api.php';

    /**
     * @var int $id ID аккаунта/канала
     */
    private $id;

    /**
     * @var string $key Ключ аккаунта/канала
     */
    private $key;

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @param int    $id  ID аккаунта/канала
     * @param string $key Ключ аккаунта/канала
     */
    public function __construct(int $id, string $key)
    {
        $this->id         = $id;
        $this->key        = $key;
        $this->httpClient = HttpClient::create();
    }

    /**
     * Запрос на сервер
     *
     * @param array  $params Массив запроса
     * @param string $method (POST/GET)
     * @return array
     */
    public function request(array $params, $method = 'POST'): array
    {
        $params['id']  = $this->id;
        $params['key'] = $this->key;

        try {
            $result = $this->httpClient
                ->request($method, self::API_URL, [
                    ($method === 'POST' ? 'body' : 'query') => $params,
                ])
                ->toArray();
        } catch (\Exception $e) {
            throw new PushAllException($e->getMessage(), $e->getCode());
        }

        return $result;
    }
}