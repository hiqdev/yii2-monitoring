<?php
/**
 * Errors and performance monitoring for Yii2 applications
 *
 * @link      https://github.com/hiqdev/yii2-monitoring
 * @package   yii2-monitoring
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

return array_filter([
    'components' => [
        'i18n' => [
            'translations' => [
                'monitoring' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => '@hiqdev/yii2/monitoring/messages',
                    'sourceLanguage' => 'en-US',
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'monitoring/error/index',
        ],
        'log' => [
            'targets' => [
                'monitoring' => [
                    'class' => hiqdev\yii2\monitoring\collectors\LogTarget::class,
                    'levels' => ['error'],
                    'view' => '@hiqdev/yii2/monitoring/views/email/error.php',
                    'destinations' => ['email'],
                ],
            ],
        ],
    ],
    'bootstrap' => defined('YII_DEBUG') && YII_DEBUG && empty($params['monitoring.email.from']) ? [
        'yii2-monitoring-warning' => function () {
            Yii::warning('Monitoring is not configured');
        },
    ] : null,
    'modules' => [
        'monitoring' => [
            'class' => \hiqdev\yii2\monitoring\Module::class,
            'flagWithDomain' => isset($params['monitoring.flagWithDomain'])
                ? $params['monitoring.flagWithDomain']
                : null,
            'destinations' => [
                'email' => array_filter([
                    'class' => \hiqdev\yii2\monitoring\destinations\EmailDestination::class,
                    'from' => isset($params['monitoring.email.from'])
                        ? $params['monitoring.email.from']
                        : $params['adminEmail'],
                    'to' => isset($params['monitoring.email.to'])
                        ? $params['monitoring.email.to']
                        : $params['adminEmail'],
                    'subject' => isset($params['monitoring.email.subject'])
                        ? $params['monitoring.email.subject']
                        : null,
                ]),
            ],
        ],
    ],
]);
