<?php
/**
 * Health monitoring for Yii2 applications.
 *
 * @link      https://github.com/hiqdev/yii2-monitoring
 * @package   yii2-monitoring
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\monitoring;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\VarDumper;
use yii\log\Logger;

class Module extends \yii\base\Module
{
    const FLAG_APPLICATION = 'app';
    const FLAG_DOMAIN = 'domain';

    public $error = [];

    public $feedback = [];

    public $targets;

    /**
     * @var string Flag that will be prepended to the message title
     * Special values that will be processed in a special way:
     *  - `hiqdev\yii2\monitoring\Module::FLAG_APPLICATION` - will prefix `Yii::$app->id`
     *  - `hiqdev\yii2\monitoring\Module::FLAG_DOMAIN` - will prefix `Yii::$app->request->getHostName()`
     */
    public $flag;

    public function getTarget($name)
    {
        if (empty($this->targets[$name])) {
            throw new InvalidConfigException("no monitoring target $name defined");
        }
        if (!is_object($this->targets[$name])) {
            $this->targets[$name] = Yii::createObject($this->targets[$name]);
        }

        return $this->targets[$name];
    }

    protected $_flagText;

    public function getFlagText()
    {
        if ($this->_flagText === null) {
            $this->_flagText = $this->detectFlagText($this->flag);
        }

        return $this->_flagText;
    }

    public function detectFlagText($flag)
    {
        switch ($flag) {
            case self::FLAG_APPLICATION:
                return Yii::$app->id;
            case self::FLAG_DOMAIN:
                return Yii::$app->request->getHostName();
            default:
                return $flag;
        }
    }

    public function flagEmail($email)
    {
        if (empty($this->flag)) {
            return $email;
        }

        list($nick, $host) = explode('@', $email, 2);

        return $nick . '+' . $this->getFlagText() . '@' . $host;
    }

    public function flagText($text, $delimiter = ' ')
    {
        if (empty($this->flag)) {
            return $text;
        }

        return '[' . $this->getFlagText() . ']' . $delimiter . $text;
    }

    public static function getInstance()
    {
        return Yii::$app->getModule('monitoring');
    }

    public function getDebugUrl($sessionTag = null)
    {
        if (empty($sessionTag)) {
            $sessionTag = $this->getDebugTag();
        }

        return Yii::$app->getUrlManager()->createAbsoluteUrl([
            '/debug/default/view',
            'panel' => 'log',
            'tag' => $sessionTag,
        ]);
    }

    public function getDebugTag()
    {
        if (!Yii::$app->hasModule('debug')) {
            return null;
        }

        return Yii::$app->getModule('debug')->logTarget->tag;
    }

    public function prepareMessageData($message)
    {
        list($load, $level, $category, $timestamp) = $message;
        $dump = $load;
        $throwable = null;
        if (!is_string($load)) {
            // exceptions may not be serializable if in the call stack somewhere is a Closure
            if ($load instanceof \Throwable || $load instanceof \Exception) {
                $dump = (string) $load;
                $throwable = $load;
            } else {
                $dump = VarDumper::export($load);
            }
        }
        $traces = [];
        if (isset($message[4])) {
            foreach ($message[4] as $trace) {
                $traces[] = "in {$trace['file']}:{$trace['line']}";
            }
        }

        return [
            'level'     => Logger::getLevelName($level),
            'time'      => date('c', $timestamp),
            'category'  => $category,
            'traces'    => $traces,
            'text'      => $dump,
            'throwable' => $throwable,
            'debugUrl'  => $this->getDebugUrl(),
        ];
    }

    public function prepareSubject($message, $subject = null)
    {
        return $this->flagText($this->rawSubject($message, $subject));
    }

    public function rawSubject($message, $subject = null)
    {
        if ($subject) {
            return $subject;
        }

        $load = reset($message);

        if (is_string($load)) {
            return $load;
        } elseif ($load instanceof \Throwable || $load instanceof \Exception) {
            return get_class($load) . ': ' . $load->getMessage();
        } else {
            return VarDumper::export($load);
        }
    }
}
