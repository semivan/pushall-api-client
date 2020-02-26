<?php

namespace PushAll\Operation;

use PushAll\Api;
use PushAll\Operation\Traits\NotificationModelTrait;
use PushAll\PushAllException;

class NotificationOperation
{
    use NotificationModelTrait;

    private const VALID_PROPERTY_VALUES = [
        'type'     => ['self', 'broadcast', 'unicast', 'multicast'],
        'hidden'   => [0, 1, 2],
        'priority' => [-1, 0, 1],
    ];

    /**
     * @var Api
     */
    private $api;

    /**
     * @param Api    $api
     * @param string $type Тип уведомления
     */
    public function __construct(Api $api, string $type)
    {
        $this->api  = $api;
        $this->type = $type;
    }

    /**
     * Валидация данных
     *
     * @return void
     */
    private function validate()
    {
        switch (true) {
            case (!in_array($this->type, self::VALID_PROPERTY_VALUES['type'])):
                $error = 'Неверный тип уведомления';
                break;

            case (!$this->title):
                $error = 'Не установлен заголовок уведомления';
                break;

            case (!$this->text):
                $error = 'Не установлен текст уведомления';
                break;

            case (strlen($this->title) > 100):
                $error = 'Заголовок уведомления не должен превышать 100 символов';
                break;

            case (strlen($this->text) > 500):
                $error = 'Текст уведомления не должен превышать 500 символов';
                break;

            case (!in_array($this->hidden, self::VALID_PROPERTY_VALUES['hidden'])):
                $error = 'Установлен неверный срок скрытия уведомления';
                break;

            case (!in_array($this->priority, self::VALID_PROPERTY_VALUES['priority'])):
                $error = 'Установлен неверный уровень приоритета уведомления';
                break;

            case (!$this->uids AND in_array($this->type, ['unicast', 'multicast'])):
                $error = 'Не добавлен подписчик';
                break;
            
            default:
                $error = null;
                break;
        }

        if ($error) {
            throw new PushAllException($error);
        }
    }

    private function getParams(): array
    {
        $params = [
            'type'     => $this->type,
            'title'    => $this->title,
            'text'     => $this->text,
            'hidden'   => $this->hidden,
            'encode'   => $this->encode,
            'priority' => $this->priority
        ];

        if ($this->type === 'unicast') {
            $params['uid'] = $this->uids[0];
        }

        if ($this->type === 'multicast') {
            $params['uids'] = json_encode($this->uids);
        }

        if ($this->url) {
            $params['url'] = $this->url;
        }

        if ($this->icon) {
           $params['icon'] = $this->icon;
        }

        if ($this->additional) {
            $params['additional'] = $this->additional;
        }

        return $params;
    }

    /**
     * Отправить уведомление
     *
     * @return array
     */
    public function send(): array
    {
        $this->validate();

        return $this->api->request($this->getParams());
    }
}