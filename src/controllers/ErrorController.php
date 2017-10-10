<?php
/**
 * Health monitoring for Yii2 applications
 *
 * @link      https://github.com/hiqdev/yii2-monitoring
 * @package   yii2-monitoring
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\monitoring\controllers;

use hiqdev\yii2\monitoring\actions\ErrorAction;
use hiqdev\yii2\monitoring\logic\DebugSessionSaver;
use hiqdev\yii2\monitoring\logic\FeedbackSender;
use hiqdev\yii2\monitoring\models\FeedbackForm;
use Yii;
use yii\web\Controller;

class ErrorController extends Controller
{
    public function actions()
    {
        return [
            'index' => ErrorAction::class,
        ];
    }

    public function actionSend()
    {
        $form = new FeedbackForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            /** @var FeedbackSender $sender */
            Yii::createObject(DebugSessionSaver::class, [$form->session_tag])->run();
            $sender = Yii::createObject(FeedbackSender::class, [$form]);

            return $this->render('sent', [
                'model' => $form,
                'success' => $sender->send(),
            ]);
        }

        return $this->redirect(Yii::$app->getHomeUrl());
    }

    public function actionTest()
    {
        Yii::error('testing error');
        throw new \Exception('testing exception');
    }
}
