<?php
/**
 * Health monitoring for Yii2 applications
 *
 * @link      https://github.com/hiqdev/yii2-monitoring
 * @package   yii2-monitoring
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

$env = defined('YII_ENV') ? YII_ENV : 'prod';

return [
    'adminEmail'                    => null,

    'monitoring.flag'               => \hiqdev\yii2\monitoring\Module::FLAG_APPLICATION,
    'monitoring.feedback.subject'   => 'Error feedback',
    'monitoring.email.subject'      => null,
    'monitoring.email.from'         => null,
    'monitoring.email.to'           => null,

    'sentry.dsn'                    => null,
    'sentry.loader.script'          => null,
    'sentry.enabled'                => true,
    'sentry.environment'            => $env,
];
