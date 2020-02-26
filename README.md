# PHP API клиент для PushAll.ru

## Требования
* PHP >= 7.1
* [symfony/http-client](https://github.com/symfony/http-client)


## Установка
```sh
composer require semivan/pushall-api-client
```


## Использование
```php
$client = new \PushAll\PushAllClient($id, $key);
```


### Аутентификация подписчика
```php
$userId = $client->oAuth($_GET('code'));
```


### Отправка уведомлений
```php
// Уведомление себе
$result = $client->selfNotification()
    ->setTitle('Title')
    ->setText('Text')
    ->send();

// Уведомление всем подписчикам канала
$result = $client->broadcastNotification()
    ->setTitle('Title')
    ->setText('Text')
    ->send();

// Уведомление определенным подписчикам канала
$result = $client->multicastNotification()
    ->setTitle('Title')
    ->setText('Text')
    ->addUid(11111)
    ->addUid(22222)
    ->send();

// Уведомление одному подписчику канала
$result = $client->unicastNotification()
    ->setTitle('Title')
    ->setText('Text')
    ->addUid(11111)
    ->send();
```


### Получение списков
```php
// Уведомлений
$result = $client
    ->showList()
    ->getNotifications();

// Подписчиков
$result = $client
    ->showList()
    ->getUsers();
```