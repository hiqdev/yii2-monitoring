<?php
/**
 * Errors and performance monitoring for Yii2 applications
 *
 * @link      https://github.com/hiqdev/yii2-monitoring
 * @package   yii2-monitoring
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\monitoring\logic;

use hiqdev\yii2\monitoring\models\FeedbackForm;
use hiqdev\yii2\monitoring\Module;
use yii\base\InvalidConfigException;
use yii\base\Object;
use yii\mail\MailerInterface;

/**
 * ErrorSender formats and sends errors.
 */
class ErrorSender extends Object
{
    /**
     * @var FeedbackForm
     */
    private $feedbackForm;
    /**
     * @var MailerInterface
     */
    private $mailer;
    /**
     * @var string
     */
    public $from;
    /**
     * @var string
     */
    public $to;
    /**
     * @var string
     */
    public $subject;
    /**
     * @var string
     */
    public $view;

    /**
     * @param MailerInterface $mailer
     * @param array $options
     */
    public function __construct(MailerInterface $mailer, $options = [])
    {
        parent::__construct($options);

        $this->feedbackForm = $feedbackForm;
        $this->mailer = $mailer;

        $this->checkOptions();
    }

    /**
     * @throws InvalidConfigException when one of required configuration fields is not filled properly
     */
    private function checkOptions()
    {
        foreach (['from', 'to', 'subject', 'view'] as $option) {
            if (!isset($this->{$option})) {
                throw new InvalidConfigException("Property \"$option\" property must be set");
            }
        }
    }

    /**
     * @return bool whether email was sent successfully
     */
    public function send()
    {
        $module = Module::getInstance();

        return $this->mailer
            ->compose($this->view, ['form' => $this->feedbackForm])
            ->setTo($this->to)
            ->setFrom($module->flagEmail($this->from))
            ->setSubject($module->flagText($this->subject))
            ->send();
    }
}
