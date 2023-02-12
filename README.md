# Laravel Error Tracker 📥

[![Latest Version on Packagist [link-packagist](https://img.shields.io/packagist/dependency-v/dnj/dnj/laravel-error-tracker-server)
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]][link-license]
[![Testing status][ico-workflow-test]][link-workflow-test]

https://img.shields.io/appveyor/build/dnj/https://github.com/dnj/laravel-error-tracker-server?style=flat-square

## Introduction

This package is specifically built for **laravel** error tracking.

* Features include:
    * Application Management
    * Device Management
    * Log Management
* Latest versions of PHP and PHPUnit and PHPCsFixer
* Best practices applied:
    * [`README.md`][link-readme] (badges included)
    * [`LICENSE`][link-license]
    * [`composer.json`][link-composer-json]
    * [`phpunit.xml`][link-phpunit]
    * [`.gitignore`][link-gitignore]
    * [`.php-cs-fixer.php`][link-phpcsfixer]

## Installation

Require this package with composer.

```shell
composer require dnj/laravel-error-tracker-server
```

Laravel uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

#### Copy the package config to your local config with the publish command:

```shell
php artisan vendor:publish --provider="dnj\ErrorTracker\Laravel\Server"
```

#### Config file

```php
<?php

return [
    // Define your user model class for connect entities to users.
    'user_model' => null,

    'routes' => [
        'enable' => true,
        'prefix' => 'log', // example: log, device, etc ... , 
    ],
];

```

---

ℹ️ **Note**
> User activity logs are **enabled** by default, if you want to save them set `$userActivityLog` to false.

Example :

```php
$appManager = app(\dnj\ErrorTracker\Contracts\IApp::class);
$app = $appManager->store(
  title:'Sell Department',
  ownerId: 1,
  OwnerIdColumn: 'owner_id',
  extra: json_encode(['data' => 'etc']),
  userActivityLog: false  // disabled 
); 
```

## Working With Application:

* Search Applications:

```php
$appManager = app(\dnj\ErrorTracker\Contracts\IApp::class);

$app = $appManager->search(
  filters:
  ['title' => 'sales'], 
  ['owner' => 1], 
  ['user' => '1']
);
```

* Create new Application:

```php
$appManager = app(\dnj\ErrorTracker\Contracts\IAppManager::class);

$app = $appManager->store(
        title:'new application',
        ownerId: 1,
        OwnerIdColumn: 'owner_id',
        extra: json_encode(['data' => 'etc']));
```

* Update Application:

```php
$appManager = app(\dnj\ErrorTracker\Contracts\IAppManager::class);

$app = $appManager->update(
  id:1,
  changes: [
            'title' => 'new title', 
            'ownerId' => 1, 
            'extra' => ['any'],
           ]
);
```

* Delete application:

```php
$appManager = app(\dnj\ErrorTracker\Contracts\IAppManager::class);

$appManager->destroy(
  id:1,
  userActivityLog: false,
);

```

***

## Working With Device:

* Search Device:

```php
$deviceManager = app(\dnj\ErrorTracker\Contracts\IDeviceManager::class);

$app = $deviceManager->search(
  filters:
  ['title' => 'device'], 
  ['owner' => 1], 
  ['user' => '1']
);
```

* Create new device:

```php
$deviceManager = app(\dnj\ErrorTracker\Contracts\IDeviceManager::class);

$app = $deviceManager->store(
        title:'new device',
        ownerId: 1,
        OwnerIdColumn: 'owner_id',
        extra: json_encode(['data' => 'etc']));
```

* Update Device:

```php
$deviceManager = app(\dnj\ErrorTracker\Contracts\IDeviceManager::class);

$device = $deviceManager->update(
  id:1,
  changes: [
            'title' => 'new device name', 
            'ownerId' => 1, 
            'extra' => ['any'],
           ]
);
```

* Delete application:

```php
$deviceManager = app(\dnj\ErrorTracker\Contracts\IDeviceManager::class);

$deviceManager->destroy(
  id:1,
  userActivityLog: false,
);
```

***

## Working With Log:

* Search Device:

```php
use \dnj\ErrorTracker\Contracts\LogLevel;
$logManager = app(\dnj\ErrorTracker\Contracts\ILogManager::class);

$log = $logManager->search(
  filters:
  ['apps' => 1],                 // app id  
  ['devices' => 1],              // devices id  
  ['level' => LogLevel::INFO]    // importance
  ['message' => 'text']          // message
  ['unread' => true]             // bool = true OR false
  ['user' => 1]                  // user id 
);
```

* Create new log:

```php
use \dnj\ErrorTracker\Contracts\LogLevel;

$logManager = app(\dnj\ErrorTracker\Contracts\ILogManager::class);

$log = $logManager->store(
        app: 1,                                          // app id 
        device: 1,                                       // device id
        level: LogLevel::INFO,                           // importance
        message: 'message',                              // message
        data: ['data' => 'any'],                         // data 
        read: ['userId' => 1, 'readAt' => Carbon::now()] // read or not read 
        extra: json_encode(['data' => 'etc'])            // extra 
        );
```

* Mark as read log:

```php
$logManager = app(\dnj\ErrorTracker\Contracts\ILogManager::class);

$log = $logManager->markAsRead(
  id:1,
  readAt: Carbon::now(); 
);


```
* Mark as unread log:

```php
$logManager = app(\dnj\ErrorTracker\Contracts\ILogManager::class);

$log = $logManager->markAsUnread(
  id:1,
  userId: null, 
  readAt: null,
);
```

* Delete log:

```php
$logManager  = app(\dnj\ErrorTracker\Contracts\ILogManager::class);

$logManager->destroy(
  id:1,
  userActivityLog: false,
);
```

***

## Testing

You can run unit tests with PHP Unit:

```php
./vendor/bin/phpunit
```

## How To use restful API

A document in YAML format has been prepared for better familiarization and use of package web services. which is placed
in the `docs/APIs` folder.

**Postman:**

* laravel-error-tracker-server.json

**Open API:**

* openApi.yaml

To use this file, you can import it on the [stoplight.io](https://stoplight.io) site and see all available web services.
Or open with PhpStorm.

## Contribution

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any
contributions you make are greatly appreciated.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also
simply open an issue with the tag "enhancement". Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## Security

If you discover any security-related issues, please email [security@dnj.co.ir](mailto:security@dnj.co.ir) instead of
using the issue tracker.

## License

The MIT License (MIT). Please
see [License File](https://github.com/dnj/laravel-error-tracker-server/blob/master/LICENSE) for more information.
