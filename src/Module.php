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
use yii\base\InvalidConfigException;
use yii\log\Logger;

class Module extends \yii\base\Module
{
    public $error = [];

    public $feedback = [];

    public $destinations;

    public $flagWithDomain;

    public function export(CollectorInterface $collector)
    {
        foreach ($collector->getMessages() as $message) {
            $this->exportMessage($collector->getDestinations(), $message);
        }
    }

    public function exportMessage($destinations, $message)
    {
        foreach ($destinations as $name) {
            $destination = $this->getDestination($name);
            $destination->export($message);
        }
    }

    public function getDestination($name)
    {
        if (empty($this->destinations[$name])) {
            throw new InvalidConfigException("no monitoring destination $name defined");
        }
        if (!is_object($this->destinations[$name])) {
            $this->destinations[$name] = Yii::createObject($this->destinations[$name]);
        }

        return $this->destinations[$name];
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
        return Yii::$app->getModule('monitoring');
    }

    public function getDebugLogLink()
    {
        return $url ? "See debug log: $url\n\n" : '';
    }

    public function getDebugSessionUrl($sessionTag = null)
    {
        if (empty($sessionTag)) {
            $sessionTag = $this->getDebugSessionTag();
        }

        return Yii::$app->getUrlManager()->createAbsoluteUrl([
            '/debug/default/view',
            'panel' => 'log',
            'tag' => $sessionTag,
        ]);
    }

    public function getDebugSessionTag()
    {
        if (!Yii::$app->hasModule('debug')) {
            return null;
        }

        return Yii::$app->getModule('debug')->logTarget->tag;
    }

    public function getView($message)
    {
        return $this->error['view'];
    }
}
