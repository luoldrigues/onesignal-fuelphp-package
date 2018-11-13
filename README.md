OneSignal FuelPHP Package.
======================

An open source package for FuelPHP that integrate the [OneSignal platform](http://onesignal.com) into your project using Curl native calls. Written by [Luan Rodrigues](https://github.com/luoldrigues).


## Index
 * [Summary](#summary)
 * [Installation](#installation)
 * [Configurations](#configurations)
    * [OneSignal App ID](#onesignal-app-id)
    * [Rest Api Key](#rest-api-key)
    * [Debug Package](#debug-package)
 * [How to get my key and ids](#how-to-get-my-key-and-ids)
 * [Usage](#usage)
    * [Create an instance](#create-an-instance)
    * [Setup keys and ids programmaticaly](#setup-keys-and-ids-programmaticaly)
    * [Send a push notification to specific user(s)](#send-a-push-notification-to-specific-users)
    * [Full example](#full-example)
 * [Licence](#licence)


## Summary
With this module you'll be able to:

* Send Push Notifications
  * for a specific user(s)
  * [TODO] for segments


## Installation

Download this repository copy the "onesignal" folder and paste in the packages folder (`fuel/packages`).

Now, you should be able to see the config file in the folder `fuel/packages/onesignal/config/`.


## Configurations

> NOTICE:
> If you want to make modifications to the default configuration, copy this file to your **app/config** folder, and make them in there.
>This will allow you to upgrade fuel without losing your custom config.

>You don't need to configure the config file, you can also [setup keys and ids programmaticaly](#setup-keys-and-ids-programmaticaly)

------------------------------------------

#### OneSignal App ID
**`onesignal_app_id`** : string
> Eg: "5eb5a37e-b458-11e3-ac11-000c2940e62c"

#### Rest Api Key
**`onesignal_rest_api_key`** : string
> Eg: "NGEwMGZmMjItY2NkNy0xMWUzLTk5ZDUtMDAwYzI5NDBlNjJj"

#### Debug Package
**`debug`** : boolean

------------------------------------------

Config file:
```php
<?php

return [
    /**
     * string OneSignal App ID
     * Something like "5eb5a37e-b458-11e3-ac11-000c2940e62c"
     */
    'onesignal_app_id' => '',

    /**
     * string Rest Api Key
     * Something like "NGEwMGZmMjItY2NkNy0xMWUzLTk5ZDUtMDAwYzI5NDBlNjJj"
     */
    'onesignal_rest_api_key' => '',

    /**
     * boolean Debug
     * Enable to get debug messages
     */
    'debug' => false,
];
```


## How to get my key and ids
Please take a look at the official documentation [https://documentation.onesignal.com/docs/accounts-and-keys#section-keys-ids](https://documentation.onesignal.com/docs/accounts-and-keys#section-keys-ids)


## Usage
Before you use this package, you must load it.
```php
    // Load package
    \Package::load('Onesignal');
```
If you have any question here, please take a look at [FuelPHP Package Class](https://fuelphp.com/docs/classes/package.html)


### Create an instance
In order to use the package you'll need to create an instance
```php
    $onesignal = new Onesignal;
```


### Setup keys and ids programmaticaly
This step is optional. If you don't want to setup the config file or if you are wondering about use this package for multiple apps, you can setup the app keys programmatically (on run time) as the example below, it's very easy.
```php
    // Use your own app_id and rest_api_key.
    $onesignal_app_id = '5eb5a37e-b458-11e3-ac11-000c2940e62c';
    $onesignal_rest_api_key = 'NGEwMGZmMjItY2NkNy0xMWUzLTk5ZDUtMDAwYzI5NDBlNjJj';

    $onesignal->set_configs($onesignal_app_id, $onesignal_rest_api_key);
```


### Send a push notification to specific user(s)
Create a push notification and send based on OneSignal PlayerIds.
```php
    $onesignal->send_message_users(
        array("en" => "English Message"), // message
        array("6392d91a-b206-4b7b-a620-cd68e32c3a76","76ece62b-bcfe-468c-8a78-839aeaa8c5fa","8e0f21fa-9a5a-4ae7-a9a6-ca1f24294b86"), // destination player_ids
        array("foo" => "bar") // extra data (optional)
    );
```


### Full example
```php
    // Create a new instance
    $onesignal = new Onesignal;

    // Use your own app_id and rest_api_key.
    $onesignal_app_id = '5eb5a37e-b458-11e3-ac11-000c2940e62c';
    $onesignal_rest_api_key = 'NGEwMGZmMjItY2NkNy0xMWUzLTk5ZDUtMDAwYzI5NDBlNjJj';

    // Setup configs programmaticaly
    $onesignal->set_configs($onesignal_app_id, $onesignal_rest_api_key);

    // Send a push notification to specific user(s)
    $onesignal->send_message_users(
        array("en" => "English Message"), // message
        array("6392d91a-b206-4b7b-a620-cd68e32c3a76"), // destination player_ids
        array("foo" => "bar") // extra data (optional)
    );

```


-------------------------------------------------------------------
## Licence

MIT License - Copyright (c) 2018 Luan Rodrigues

This is a free software! You are allowed to change and redistribute it for free.

Written by Luan Rodrigues - [https://github.com/luoldrigues/onesignal-fuelphp-package](https://github.com/luoldrigues/onesignal-fuelphp-package)
