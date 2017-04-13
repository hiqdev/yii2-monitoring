<?php
/**
 * Errors and performance monitoring for Yii2 applications
 *
 * @link      https://github.com/hiqdev/yii2-monitoring
 * @package   yii2-monitoring
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

return [
    'adminEmail' => null,
    'monitoring' => [
        'log.subject' => 'Error Log',
        'feedback.subject' => 'Error feedback',
        'flagWithDomain' => true,
        'email' => [
            'from' => null,
            'to' => null,
        ],
    ],
];
