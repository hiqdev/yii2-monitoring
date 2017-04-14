<?php
/**
 * Errors and performance monitoring for Yii2 applications
 *
 * @link      https://github.com/hiqdev/yii2-monitoring
 * @package   yii2-monitoring
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\monitoring\targets;

use hiqdev\yii2\monitoring\Module;
use Yii;
use yii\base\InvalidConfigException;
use yii\mail\MailerInterface;

class EmailTarget extends \yii\log\Target
{
    public $view;

    public $from;
    public $to;
    public $subject;

    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(MailerInterface $mailer, $options = [])
    {
        parent::__construct($options);
        $this->mailer = $mailer;
    }

    public function export()
    {
        $module = Module::getInstance();

        foreach ($this->messages as $message) {
            return $this->mailer
                ->compose($this->view, $module->prepareMessageData($message, $this))
                ->setTo($this->to)
                ->setFrom($module->flagEmail($this->from))
                ->setSubject($module->prepareSubject($message, $this->subject))
                ->send();
        }
    }
}
