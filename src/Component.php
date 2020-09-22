<?php
/**
 * Health monitoring for Yii2 applications
 *
 * @link      https://github.com/hiqdev/yii2-monitoring
 * @package   yii2-monitoring
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\monitoring;

use Sentry\SentrySdk;
use Yii;

class Component extends \yii\base\Component
{
    public function init()
    {
        if (!empty(SentrySdk::getCurrentHub()->getClient())) {
            return;
        }
        $params = Yii::$app->params;
        if (empty($params['sentry.dsn']) || empty($params['sentry.enabled'])) {
            return;
        }

        \Sentry\init(['dsn' => $params['sentry.dsn']]);
    }
}
