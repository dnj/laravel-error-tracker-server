# Laravel Error Tracker 📥

![Packagist Dependency Version](https://img.shields.io/packagist/dependency-v/dnj/dnj/laravel-error-tracker-server)
![GitHub all releases](https://img.shields.io/github/downloads/dnj/laravel-error-tracker-server/total)
![GitHub](https://img.shields.io/github/license/dnj/laravel-error-tracker-server)
![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/dnj/laravel-error-tracker-server/ci.yml)

## Introduction

This package is specifically built for **laravel** error tracking.

* Features include:
    * Application Management
    * Device Management
    * Log Management
* Latest versions of PHP and PHPUnit and PHPCsFixer
* Best practices applied:
    * [`README.md`](https://github.com/dnj/laravel-error-tracker-server/blob/master/README.md) (badges included)
    * [`LICENSE`](https://github.com/dnj/laravel-error-tracker-server/blob/master/LICENSE)
    * [`composer.json`](https://github.com/dnj/laravel-error-tracker-server/blob/master/composer.json)
    * [`phpunit.xml`](https://github.com/dnj/laravel-error-tracker-server/blob/master/phpunit.xml)
    * [`.gitignore`](https://github.com/dnj/laravel-error-tracker-server/blob/master/.gitignore)
    * [`.php-cs-fixer.php`](https://github.com/dnj/laravel-error-tracker-server/blob/master/.php-cs-fixer.php)

## Installation

Require this package with composer.

```shell
composer require dnj/laravel-error-tracker-server
```

Laravel uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

#### Copy the package config to your local config with the publish command:

```shell
php artisan vendor:publish --provider="dnj\ErrorTracker\Laravel\Server\ServiceProvider"
```

#### Config file

```php
<?php

return [
    // Define your user model class for connect entities to users.
    'user_model' => \dnj\AAA\Models\User::class,

    'routes' => [
        'enable' => true,
        'prefix' => 'log', // example: log, device, etc ... , 
    ],
];

```

---

ℹ️ **Note**
> User activity logs are **disabled** by default, if you want to save them set `$userActivityLog` to true.

Example :

```php
use dnj\ErrorTracker\Contracts\IAppManager;

$appManager = app(IAppManager::class);

$app = $appManager->store(
  title: 'Android mobile app',
  owner: 1,
  meta: ['key' => 'value']),
  userActivityLog: false,
); 
```

## Working With Application:

* Search Applications:

```php
use dnj\ErrorTracker\Contracts\IAppManager;

$appManager = app(IAppManager::class);

$apps = $appManager->search(
  filters: [
    'title' => 'mobile app'
    'owner' => 2
  ],
);
```

* Create new Application:

```php
use dnj\ErrorTracker\Contracts\IAppManager;

$appManager = app(IAppManager::class);

$app = $appManager->store(
  title: 'Android mobile app',
  owner: 1,
  meta: ['key' => 'value']),
  userActivityLog: false,
); 
```

* Update Application:

```php
use dnj\ErrorTracker\Contracts\IAppManager;

$appManager = app(IAppManager::class);

$app = $appManager->update(
  app: 1,
  changes: [
    'title' => 'new title',
    'owner' => 2,
  ],
  userActivityLog: true,
); 
```

* Delete application:

```php
use dnj\ErrorTracker\Contracts\IAppManager;

$appManager = app(IAppManager::class);

$appManager->destroy(
  log: 1,
  userActivityLog: false,
);

```

***

## Working With Device:

* Search Device:

```php
use dnj\ErrorTracker\Contracts\IDeviceManager;

$deviceManager = app(IDeviceManager::class);

$devices = $deviceManager->search(
  filters: [
    'title' => 'Nokia Mobile'
    'owner' => 2
  ],
);
```

* Create new device:

```php
use dnj\ErrorTracker\Contracts\IDeviceManager;

$deviceManager = app(IDeviceManager::class);

$device = $deviceManager->store(
  title: 'Nokia mobile',
  owner: 1,
  meta: ['key' => 'value']),
  userActivityLog: false,
); 
```

* Update Device:

```php
use dnj\ErrorTracker\Contracts\IDeviceManager;

$deviceManager = app(IDeviceManager::class);

$device = $deviceManager->update(
  device: 3,
  changes: [
    'title' => 'My Nokia Mobile',
    'owner' => 2,
    'meta' => ['serialNo' => 55245252]
  ],
  userActivityLog: true,
); 

```

* Delete application:

```php
use dnj\ErrorTracker\Contracts\IDeviceManager;

$deviceManager = app(IDeviceManager::class);

$deviceManager->destroy(
  log: 3,
  userActivityLog: false,
);
```

***

## Working With Log:

* Search Device:

```php
use dnj\ErrorTracker\Contracts\ILogManager;
use dnj\ErrorTracker\Contracts\LogLevel;

$logManager = app(ILogManager::class);

$logs = $logManager->search(
  filters: [
    'apps' => [1,2],
    'devices' => [1],
    'levels' => [LogLevel::DEBUG],
    'message' => 'important flag',
    'unread' => true,
  ]
);
```

* Create new log:

```php
use dnj\ErrorTracker\Contracts\ILogManager;
use dnj\ErrorTracker\Contracts\LogLevel;

$logManager = app(ILogManager::class);

$log = $logManager->store(
  app: 1,
  device: 1,
  level: LogLevel::INFO,
  message: 'App has been started',
);
```

* Mark as read log:

```php
use dnj\ErrorTracker\Contracts\ILogManager;
use dnj\ErrorTracker\Contracts\LogLevel;

$logManager = app(ILogManager::class);

$log = $logManager->markAsRead(
  log: 44,
  user: 3
);
```
* Mark as unread log:

```php
use dnj\ErrorTracker\Contracts\ILogManager;
use dnj\ErrorTracker\Contracts\LogLevel;

$logManager = app(ILogManager::class);

$log = $logManager->markAsUnread(
  log: 44,
);
```

* Delete log:

```php
use dnj\ErrorTracker\Contracts\ILogManager;

$logManager = app(ILogManager::class);

$logManager->destroy(
  log: 44,
  userActivityLog: true,
);
```

***

## Testing

You can run unit tests with PHP Unit:

```php
./vendor/bin/phpunit
```


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
