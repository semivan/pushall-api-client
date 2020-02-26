<?php

namespace PushAll\Operation\Traits;

use PushAll\PushAllException;

trait NotificationModelTrait
{
    /**
     * @var string $type Тип уведомления
     */
    protected $type;

    /**
     * @var int[] $uids Массив подписчиков
     */
    protected $uids;

    /**
     * @var string $title Заголовок уведомления
     */
    protected $title;

    /**
     * @var string $text Текст уведомления
     */
    protected $text;

    /**
     * @var int $hidden Срок скрытия уведомления
     */
    protected $hidden = 0;

    /**
     * @var string $encode Кодировка
     */
    protected $encode = 'UTF-8';

    /**
     * @var int $priority Приоритет
     */
    protected $priority = 0;

    /**
     * @var string $url Aдрес по которому будет осуществлен переход по клику
     */
    protected $url;

    /**
     * @var string $icon Иконка уведомления
     */
    protected $icon;

    /**
     * @var string $additional Дополнения
     */
    protected $additional;

    /**
     * @return string Тип уведомления
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type Тип уведомления
     * @return $this
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Добавить подписчика
     *
     * @param int $uids ID подписчика
     * @return $this
     */ 
    public function addUid(int $uid)
    {
        $this->uids[] = $uid;

        return $this;
    }

    /**
     * @param string $title Заголовок уведомления
     * @return $this
     */ 
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $text Текст уведомления
     * @return $this
     */ 
    public function setText(string $text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @param int $hidden Срок скрытия уведомления
     * 
     * 0 - не скрывать (по-умолчанию);
     * 
     * 1 - сразу скрыть уведомление из истории пользователей;
     * 
     * 2 - скрыть только из ленты.
     * 
     * @return $this
     */ 
    public function setHidden(int $hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * @param string $encode Кодировка (по-умолчанию: UTF-8)
     * @return $this
     */ 
    public function setEncode(string $encode)
    {
        $this->encode = $encode;

        return $this;
    }

    /**
     * @param int $priority Приоритет
     * 
     * -1 - не важные, менее заметны, не будят устройство;
     * 
     * 0 - по по-умолчанию;
     * 
     * 1 - более заметные, быстрее сажают аккумулятор.
     * @return $this
     */ 
    public function setPriority(int $priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @param string|null $url Aдрес по которому будет осуществлен переход по клику
     * @return $this
     */ 
    public function setUrl(string $url = null)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param string|null $icon Иконка уведомления
     * @return $this
     */ 
    public function setIcon(string $icon = null)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Добавить крутноеизображение с двумя кнопками
     *
     * @param string $url     URL изображения
     * @param array  $button1 Массив ['title' => '<title>', 'url' => '<url>']
     * @param array  $button2 Массив ['title' => '<title>', 'url' => '<url>']
     * @return $this
     */
    public function setBigImage(string $url, array $button1, array $button2)
    {
        if (empty($button1['title']) OR empty($button1['url']) OR empty($button2['title']) OR empty($button2['url'])) {
            throw new PushAllException('Неверные параметры для кнопок крупного изображения');
        }

        $this->additional = json_encode([
            'bigimage' => $url,
            'actions'  => [$button1, $button2],
        ]);

        return $this;
    }
}