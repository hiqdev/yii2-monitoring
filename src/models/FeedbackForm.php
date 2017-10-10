<?php
/**
 * Health monitoring for Yii2 applications
 *
 * @link      https://github.com/hiqdev/yii2-monitoring
 * @package   yii2-monitoring
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\monitoring\models;

use hiqdev\yii2\monitoring\Module;
use Yii;
use yii\base\Model;

class FeedbackForm extends Model
{
    /**
     * @var string
     */
    public $message;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $session_tag;

    public function attributes()
    {
        return ['message', 'email', 'session_tag'];
    }

    public function attributeLabels()
    {
        return [
            'message' => Yii::t('monitoring', 'Message'),
        ];
    }

    public function rules()
    {
        return [
            [['message'], 'required'],
            [['email'], 'safe', 'when' => Yii::$app->user->isGuest],
            [['session_tag'], 'safe'],
        ];
    }

    public function getDebugUrl()
    {
        return $this->getModule()->getDebugUrl($this->session_tag);
    }

    public function getModule()
    {
        return Module::getInstance();
    }
}
