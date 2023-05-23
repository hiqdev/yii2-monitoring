<?php
/**
 * Health monitoring for Yii2 applications
 *
 * @link      https://github.com/hiqdev/yii2-monitoring
 * @package   yii2-monitoring
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\monitoring\actions;

use hiqdev\yii2\monitoring\models\FeedbackForm;
use Yii;

class ErrorAction extends \yii\web\ErrorAction
{
    protected function getViewRenderParams()
    {
        return array_merge(parent::getViewRenderParams(), [
            'model' => $this->buildFeedbackForm(),
        ]);
    }

    private function buildFeedbackForm()
    {
        $model = new FeedbackForm();

        if (!defined('HISITE_TEST') && Yii::$app->hasModule('debug')) {
            /** @var \yii\debug\Module $debug */
            $debug = Yii::$app->getModule('debug');
            $model->session_tag = $debug->logTarget->tag;
        }

        return $model;
    }
}
