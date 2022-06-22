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
use yii\web\User;
use yii\web\UserEvent;

class Component extends \yii\base\Component
{
    public function init()
    {
        $this->initSentry();
        $this->initNewRelic();
    }

    private function initSentry(): void
    {
        if (!class_exists(SentrySdk::class)) {
            return;
        }
        if (!empty(SentrySdk::getCurrentHub()->getClient())) {
            return;
        }

        $params = Yii::$app->params;
        if (empty($params['sentry.dsn']) || empty($params['sentry.enabled'])) {
            return;
        }

        \Sentry\init([
            'dsn' => $params['sentry.dsn'],
            'error_types' => E_ALL,
        ]);
    }

    private function initNewRelic()
    {
        if (!extension_loaded('newrelic')) {
            return;
        }

        // We do not want to report insignificant errors to New Relic
        ini_set('newrelic.error_collector.ignore_errors', E_DEPRECATED | E_STRICT | E_NOTICE | E_WARNING);
        newrelic_capture_params();
        if (php_sapi_name() === 'cli') {
            newrelic_name_transaction($_SERVER['argv']);
        } else {
            newrelic_name_transaction(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        }

        // When user is authenticated, add user info
        if (Yii::$app->has('user')) {
            $user = Yii::$app->user;
            $user->on(User::EVENT_AFTER_LOGIN, function (UserEvent $event) {
                $user = $event->identity;
                newrelic_add_custom_parameter('user.id', $user->getId());

                if (method_exists($user, 'getLogin')) {
                    newrelic_add_custom_parameter('user.login', $user->getLogin());
                }
            });
        }
    }
}
