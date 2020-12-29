<?php
/**
 * Health monitoring for Yii2 applications
 *
 * @link      https://github.com/hiqdev/yii2-monitoring
 * @package   yii2-monitoring
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

use hiqdev\yii2\monitoring\logic\FeedbackSender;

return array_filter([
    'components' => [
        'errorHandler' => [
            'errorAction' => 'monitoring/error/index',
        ],
        'i18n' => [
            'translations' => [
                'monitoring' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => dirname(__DIR__) . '/src/messages',
                    'sourceLanguage' => 'en-US',
                ],
            ],
        ],
    ],
    'container' => [
        'definitions' => [
            FeedbackSender::class => [
                'class' => FeedbackSender::class,
                'view' => '@vendor/hiqdev/yii2-monitoring/src/views/mail/feedback.php',
                'from' => $params['monitoring.email.from'] ?: $params['adminEmail'],
                'to' => $params['monitoring.email.to'] ?: $params['adminEmail'],
                'subject' => $params['monitoring.feedback.subject'],
            ],
        ],
    ],
]);
