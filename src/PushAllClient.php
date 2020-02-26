<?php

namespace PushAll;

use PushAll\Operation\NotificationOperation;
use PushAll\Operation\ShowListOperation;

class PushAllClient
{
    /**
     * @var Api
     */
    private $api;

    /**
     * @param int    $id  ID аккаунта/канала
     * @param string $key Ключ аккаунта/канала
     */
    public function __construct(int $id, string $key)
    {
        $this->api = new Api($id, $key);
    }

    /**
     * Аутентификация подписчика
     *
     * @return int ID подписчика
     */
    public function oAuth(string $code): int
    {
        $result = $this->api->request([
            'type' => 'oauth',
            'code' => $code,
        ]);

        return intval($result['access_token'] ?? 0);
    }

    /**
     * Уведомление себе
     *
     * @return NotificationOperation
     */
    public function selfNotification(): NotificationOperation
    {
        return new NotificationOperation($this->api, 'self');
    }

    /**
     * Уведомления всем подписчикам канала
     *
     * @return NotificationOperation
     */
    public function broadcastNotification(): NotificationOperation
    {
        return new NotificationOperation($this->api, 'broadcast');
    }

    /**
     * Уведомления определенным подписчикам канала
     *
     * @return NotificationOperation
     */
    public function multicastNotification(): NotificationOperation
    {
        return new NotificationOperation($this->api, 'multicast');
    }

    /**
     * Уведомление одному подписчику канала
     *
     * @return NotificationOperation
     */
    public function unicastNotification(): NotificationOperation
    {
        return new NotificationOperation($this->api, 'unicast');
    }

    /**
     * Операции со списками
     *
     * @return ShowListOperation
     */
    public function showList(): ShowListOperation
    {
        return new ShowListOperation($this->api);
    }
}