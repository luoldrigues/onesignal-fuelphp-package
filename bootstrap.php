<?php
/**
 * OneSignal FuelPHP Package
 * An open source package to FuelPhp that integrate the OneSignal platform into your project using Curl.
 *
 * @package    Onesignal
 * @version    1.0
 * @author     Luan Rodrigues
 * @license    MIT License
 * @link       https://github.com/luoldrigues/onesignal-fuelphp-package
 */

\Autoloader::add_core_namespace('Onesignal');

\Autoloader::add_classes(array(
    'Onesignal\\Onesignal'             => __DIR__.'/classes/onesignal.php',
    'Onesignal\\Exception'             => __DIR__.'/classes/onesignal.php',
    'Onesignal\\OneSignalApiException' => __DIR__.'/classes/onesignal.php',
));