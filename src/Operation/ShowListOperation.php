<?php

namespace PushAll\Operation;

use PushAll\Api;

class ShowListOperation
{
    const TYPE         = 'showlist';
    const USER_SUBTYPE = 'users';

    /**
     * @var Api
     */
    private $api;

    /**
     * @param Api $api
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     * Получить список уведомлений
     *
     * @param int $limit Ограничение количества уведомлений
     * @return array
     */
    public function getNotifications(int $limit = 10): array
    {
        $result = $this->api->request([
            'type'  => self::TYPE,
            'limit' => $limit,
        ]);

        return $result['data'] ?? $result;
    }

    /**
     * Получить уведомление
     *
     * @param int $lid ID уведомления
     * @return array
     */
    public function getNotification(int $lid): array
    {
        $result = $this->api->request([
            'type'  => self::TYPE,
            'limit' => 10,
            'lid'   => $lid,
        ]);

        return $result['data'] ?? $result;
    }

    /**
     * Получить список подписчиков
     *
     * @return array
     */
    public function getUsers(): array
    {
        $result = $this->api->request([
            'type'    => self::TYPE,
            'subtype' => self::USER_SUBTYPE,
        ]);

        return $result['data'] ?? $result;
    }

    /**
     * Получить подписчика
     *
     * @param int $uid ID подписчика
     * @return array
     */
    public function getUser(int $uid): array
    {
        $result = $this->api->request([
            'type'    => self::TYPE,
            'subtype' => self::USER_SUBTYPE,
            'uid'     => $uid,
        ]);

        return $result['data'] ?? $result;
    }
}