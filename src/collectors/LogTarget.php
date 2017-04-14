<?php
/**
 * Errors and performance monitoring for Yii2 applications
 *
 * @link      https://github.com/hiqdev/yii2-monitoring
 * @package   yii2-monitoring
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\monitoring\collectors;

use hiqdev\yii2\monitoring\CollectorInterface;
use hiqdev\yii2\monitoring\models\FeedbackForm;
use hiqdev\yii2\monitoring\Message;
use hiqdev\yii2\monitoring\Module;
use Yii;

class LogTarget extends \yii\log\Target implements CollectorInterface
{
    public $destinations = [];

    /**
     * Sends log messages to specified email addresses.
     */
    public function export()
    {
        Module::getInstance()->export($this);
    }

    public function getDestinations()
    {
        return $this->destinations;
    }

    public function getMessages()
    {
        foreach ($this->messages as $message) {
            $res[] = $this->prepareMessage($message);
        }

        return $res;
    }

    public function old()
    {
        // moved initialization of subject here because of the following issue
        // https://github.com/yiisoft/yii2/issues/1446
        if (empty($this->message['subject'])) {
            $this->message['subject'] = 'Application Log';
        }

        $this->message['from'] = $module->flagEmail($this->message['from']);
        $this->message['subject'] = $module->flagText($this->message['subject']);

        var_dump($_SERVER);
        var_dump($this->messages);
        die;
        $messages = array_map([$this, 'formatMessage'], $this->messages);
        $body = $
        $body = $this->getDebugLogLink();
        $body .= implode("\n", $messages);
        $this->composeMessage($body)->send($this->mailer);
    }

    private function getDebugLogLink()
    {
        if (!Yii::$app->hasModule('debug')) {
            return '';
        }

        $form = new FeedbackForm(['session_tag' => Yii::$app->getModule('debug')->logTarget->tag]);
        $url = $form->getDebugSessionUrl();

        return "See debug log: $url\n\n";
    }
}
