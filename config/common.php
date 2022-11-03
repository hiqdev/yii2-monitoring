<?php
/**
 * Health monitoring for Yii2 applications
 *
 * @link      https://github.com/hiqdev/yii2-monitoring
 * @package   yii2-monitoring
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

use hiqdev\yii2\monitoring\Module;
use hiqdev\yii2\monitoring\Component;
use hiqdev\yii2\monitoring\targets\EmailTarget;
use hiqdev\yii2\monitoring\targets\RedirectTarget;
use hiqdev\yii2\monitoring\targets\SentryTarget;
use Yiisoft\Composer\Config\Merger\Modifier\InsertValueBeforeKey;

$env = defined('YII_ENV') ? YII_ENV : 'prod';
$debug = defined('YII_DEBUG') && YII_DEBUG;

return array_filter([
    'bootstrap' => [
        'monitoring' => new InsertValueBeforeKey('monitoring', 'log'),
    ],
    'container' => [
        'singletons' => [
            \Sentry\State\HubInterface::class => fn () => \Sentry\SentrySdk::getCurrentHub(),
        ],
    ],
    'components' => array_filter([
        'log' => [
            'targets' => [
                'monitoring' => [
                    '__class' => RedirectTarget::class,
                    'levels' => ['error'],
                    'targets' => array_keys(array_filter([
                        'sentry' => $params['sentry.dsn'] && $params['sentry.enabled'],
                        'email'  => $env === 'prod' && $params['monitoring.email.to'],
                    ])),
                ],
                'sentry' => [
                    '__class' => SentryTarget::class,
                    'levels' => ['error', 'warning'],
                    'except' => [
                        'yii\debug\Module::checkAccess',
                    ]
                ]
            ],
        ],
        'monitoring' => [
            '__class' => Component::class,
        ],
    ]),
    'modules' => [
        'monitoring' => [
            '__class' => Module::class,
            'flag' => $params['monitoring.flag'],
            'targets' => [
                'email' => array_filter([
                    '__class' => EmailTarget::class,
                    'view' => '@vendor/hiqdev/yii2-monitoring/src/views/mail/error.php',
                    'from' => $params['monitoring.email.from'] ?: $params['adminEmail'],
                    'to' => $params['monitoring.email.to'] ?: $params['adminEmail'],
                    'subject' => $params['monitoring.email.subject'],
                ]),
                'sentry' => [
                    '__class' => SentryTarget::class,
                ],
            ],
        ],
    ],
]);
