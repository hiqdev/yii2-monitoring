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
$debug = defined('YII_DEBUG') && YII_DEBUG;

return array_filter([
    'components' => array_filter([
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
                        'sentry' => $params['sentry.dsn'],
                        'email'  => $env === 'prod' && $params['monitoring.email.to'],
                    ])),
                ],
            ],
        ],
        'sentry' => array_filter([
            'class' => \mito\sentry\Component::class,
            'enabled' => $params['sentry.enabled'],
            'dsn' => $params['sentry.dsn'],
            'environment' => $env,
        ]),
    ]),
    'bootstrap' => $debug && empty($params['monitoring.email.to']) ? [
        'yii2-monitoring-warning' => function () {
            Yii::warning('Monitoring is not configured');
        },
    ] : null,
    'modules' => [
        'monitoring' => [
            'class' => \hiqdev\yii2\monitoring\Module::class,
            'flag' => $params['monitoring.flag'],
            'targets' => [
                'email' => array_filter([
                    'class' => \hiqdev\yii2\monitoring\targets\EmailTarget::class,
                    'view' => '@hiqdev/yii2/monitoring/views/mail/error.php',
                    'from' => $params['monitoring.email.from'] ?: $params['adminEmail'],
                    'to' => $params['monitoring.email.to'] ?: $params['adminEmail'],
                    'subject' => $params['monitoring.email.subject'],
                ]),
                'sentry' => [
                    'class' => \mito\sentry\Target::class,
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
