<?php
/**
 * Errors and performance monitoring for Yii2 applications
 *
 * @link      https://github.com/hiqdev/yii2-monitoring
 * @package   yii2-monitoring
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\monitoring\models;

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
            'message' => Yii::t('error-notifier', 'Message'),
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

    public function getDebugSessionUrl()
    {
        if (empty($this->session_tag) || !Yii::$app->hasModule('debug')) {
            return null;
        }

        return Yii::$app->getUrlManager()->createAbsoluteUrl([
            '/debug/default/view',
            'panel' => 'log',
            'tag' => $this->session_tag,
        ]);
    }
}
