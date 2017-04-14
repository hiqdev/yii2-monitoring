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
                    'class' => hiqdev\yii2\monitoring\targets\RedirectTarget::class,
                    'levels' => ['error'],
                    'targets' => array_keys(array_filter([
                        /// 'sentry' => $params['sentry.dsn'], NOT IMPLEMENTED YET
                        'email'  => $params['monitoring.email.to'],
                    ])),
                ],
            ],
        ],
    ],
    'bootstrap' => defined('YII_DEBUG') && YII_DEBUG && empty($params['monitoring.email.to']) ? [
        'yii2-monitoring-warning' => function () {
            Yii::warning('Monitoring is not configured');
        },
    ] : null,
    'modules' => [
        'monitoring' => [
            'class' => \hiqdev\yii2\monitoring\Module::class,
            'flag' => $params['monitoring.flag'],
            'feedback' => [
                'subject' => $params['monitoring.feedback.subject'],
            ],
            'targets' => [
                'email' => array_filter([
                    'class' => \hiqdev\yii2\monitoring\targets\EmailTarget::class,
                    'view' => '@hiqdev/yii2/monitoring/views/mail/error.php',
                    'from' => $params['monitoring.email.from'] ?: $params['adminEmail'],
                    'to' => $params['monitoring.email.to'] ?: $params['adminEmail'],
                    'subject' => $params['monitoring.email.subject'],
                ]),
                'sentry' => [
                    'class' => \hiqdev\yii2\monitoring\targets\SentryTarget::class,
                    'dsn' => $params['sentry.dsn'],
                ],
            ],
        ],
    ],
    'container' => [
        'definitions' => [
            \hiqdev\yii2\monitoring\logic\FeedbackSender::class => [
                'class' => \hiqdev\yii2\monitoring\logic\FeedbackSender::class,
                'view' => '@hiqdev/yii2/monitoring/views/mail/feedback.php',
                'from' => $params['monitoring.email.from'] ?: $params['adminEmail'],
                'to' => $params['monitoring.email.to'] ?: $params['adminEmail'],
                'subject' => $params['monitoring.feedback.subject'],
            ],
        ],
    ],
]);
