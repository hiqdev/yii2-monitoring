<?php
/**
 * Errors and performance monitoring for Yii2 applications
 *
 * @link      https://github.com/hiqdev/yii2-monitoring
 * @package   yii2-monitoring
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\monitoring\destinations;

use hiqdev\yii2\monitoring\Module;
use Yii;
use yii\base\InvalidConfigException;
use yii\mail\MailerInterface;

class EmailDestination extends \yii\base\Object
{
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

    public function export($message)
    {
        $module = Module::getInstance();

        return $this->mailer
            ->compose($module->getView($message), $module->prepareData($message))
            ->setTo($this->to)
            ->setFrom($module->flagEmail($this->from))
            ->setSubject($module->flagText($this->subject))
            ->send();
    }
}
