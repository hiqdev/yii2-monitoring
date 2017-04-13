<?php
/**
 * Errors and performance monitoring for Yii2 applications
 *
 * @link      https://github.com/hiqdev/yii2-monitoring
 * @package   yii2-monitoring
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\monitoring;

use Yii;

class Module extends \yii\base\Module
{
    public $flagWithDomain;

    public function export(CollectorInterface $collector)
    {
        foreach ($collector->getDestinations() as $dest) {
            foreach ($collector->getMessages() as $message) {
                var_dump($dest);
                var_dump($message);
                die;
            }
        }
    }

    public function flagEmail($email)
    {
        if (empty($this->flagWithDomain)) {
            return $email;
        }

        list($nick, $host) = explode('@', $email, 2);

        return $nick . '+' . Yii::$app->request->getHostName() . '@' . $host;
    }

    public function flagText($text, $delimiter = ' ')
    {
        if (empty($this->flagWithDomain)) {
            return $text;
        }

        return '[' . Yii::$app->request->getHostName() . ']' . $delimiter . $text;
    }

    public static function getInstance()
    {
        return Yii::$app->getModule('error-notifier');
    }
}
